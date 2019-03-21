<?php

namespace App\Http\Controllers\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\AlertboxSettings;
use Carbon\Carbon;
use App\Messages;
use App\User;
use App\Fonts;

class AlertboxController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getWidget', 'getWidgetData', 'getWidgetSettings', 'postWidgetRead']]);
    }

    public function getHome()
    {
        $this->view['title'] = trans('widgets.alertbox.home.title');
        $this->view['settings'] = AlertboxSettings::user(Auth::user()->id);
        $this->view['fonts'] = Fonts::get();
        $this->view['text_animations'] = AlertboxSettings::text_animations();
        $this->view['voice_languages'] = AlertboxSettings::voice_languages();
        $this->view['voice_speakers'] = AlertboxSettings::voice_speakers();
        $this->view['images'] = Storage::disk('public')->allFiles('alertbox/images/library');
        $this->view['sounds'] = Storage::disk('public')->allFiles('alertbox/sounds/library');
        return view('widgets.alertbox.home', $this->view);
    }
    
    public function postHome(Request $request)
    {
        
        $this->validate($request, [
            'message_template' => [ 'required', 'max: 128' ],
            'image_file' => [ 'nullable', 'image' ],
            'sound_file' => [ 'nullable', 'max:3072', 'mp3_extension' ],
            'text_animation' => [ 'required', Rule::in( array_keys(AlertboxSettings::text_animations()) ) ],
            'font' => [ 'required', Rule::in( Fonts::keys() ) ],
            'sound_volume' => [ 'required', 'integer', 'min:0', 'max:100' ],
            'duration' => [ 'required', 'integer', 'min:1', 'max:25' ],
            'voice' => [ 'required', 'in:true,false' ],
            'voice_language' => [ 'required', Rule::in( array_keys(AlertboxSettings::voice_languages()) ) ],
            'voice_speaker' => [ 'required', Rule::in( array_keys(AlertboxSettings::voice_speakers()) ) ],
            'voice_emotion' => [ 'required', 'in:neutral,good,evil' ],
            'font_size' => [ 'required', 'integer', 'min:12', 'max:80' ],
            'background_color' => [ 'required', 'color' ],
            'font_color' => [ 'required', 'color' ],
            'font_color2' => [ 'required', 'color' ],
        ]);
        
        $settings = AlertboxSettings::user(Auth::user()->id);
        $data = $request->only([
            'message_template', 'text_animation', 'font', 'sound_volume', 
            'duration', 'font_color', 'font_color2', 'voice', 'voice_language',
            'voice_speaker', 'voice_emotion', 'background_color', 'font_size'
            ]);

        // Image
        if ($request->hasFile('image_file')) {
            if (stristr($settings['image'], 'library/') === FALSE)
                Storage::disk('public')->delete('alertbox/images/' . $settings['image']);
            $filename = str_random(30) . '.' . $request->image_file->extension();
            $request->image_file->storeAs('alertbox/images', $filename, 'public'); 
            $data['image'] = $filename;
        } else if (stristr($request->image, 'library/')) {
            if (Storage::disk('public')->exists('alertbox/images/library/' . basename($request->image_file))) {
                if (stristr($settings['image'], 'library/') === FALSE)
                    Storage::disk('public')->delete('alertbox/images/' . $settings['image']);
                $data['image'] = $request->image;
            } else
                return response()->json(['danger' => ['image_file' => [trans('widgets.alertbox.image_error')]]]);
        }

        // Sound
        if ($request->hasFile('sound_file')) {
            if (stristr($settings['sound'], 'library/') === FALSE)
                Storage::disk('public')->delete('alertbox/sounds/' . $settings['sound']);
            $filename = str_random(30) . '.mp3';
            $request->sound_file->storeAs('alertbox/sounds', $filename, 'public'); 
            $data['sound'] = $filename;
        } else if (stristr($request->sound, 'library/')) {
            if (Storage::disk('public')->exists('alertbox/sounds/library/' . basename($request->sound_file))) {
                if (stristr($settings['sound'], 'library/') === FALSE)
                    Storage::disk('public')->delete('alertbox/sounds/' . $settings['sound']);
                $data['sound'] = $request->sound;
            } else
                return response()->json(['danger' => ['sound_file' => [trans('widgets.alertbox.sound_error')]]]);
        }

        if ($request->{'new-token'}) {
            $data['token'] = str_random(45);
            $result['widget'] = route('widgets.aletbox.widget', [ 'token' => $data['token']]);
        }
        
        AlertboxSettings::where('user_id', Auth::user()->id)->update($data);
        $result['success'] = trans('widgets.success');
        
        return response()->json($result);
    }
    
    public function getWidget(Request $request, $token)
    {
        $this->view['settings'] = AlertboxSettings::where('token', $token)->first();
        $this->view['title'] = null;
        if (!$this->view['settings'])
            abort(403);
        $this->view['user'] = User::where('id', $this->view['settings']->user_id)->first();
        return view('widgets.alertbox.widget', $this->view);
    }
    
    public function getWidgetSettings(Request $request, $token)
    {
        $settings = AlertboxSettings::where('token', $token)->first();
        if (!$settings)
            abort(403);
        $user = User::select(['links', 'black_list_words'])->where('id', $settings->user_id)->first();
        $settings->links = $user->links;
        $settings->black_list_words = $user->black_list_words;
        return response()->json($settings);
    }
    
    public function postWidgetRead(Request $request, $token)
    {
        $settings = AlertboxSettings::where('token', $token)->first();
        if (!$settings)
            abort(403);
            
        $message = Messages::where('id', $request->id)->where('user_id', $settings->user_id)->first();
        if (!$message)
            abort(403);
        
        $message->timestamps = false;
        $message->view_status = 'true';
        $message->save();
    }
    
    public function getWidgetData(Request $request, $token)
    {
        $settings = AlertboxSettings::where('token', $token)->first();
        if (!$settings)
            abort(403);
        $user = User::select(['timezone', 'smiles'])->where('id', $settings->user_id)->first();
        $messages = Messages::where('view_status', 'false')
                            ->where('user_id', $settings->user_id)
                            ->whereIn('status', ['user', 'success'])
                            ->orderBy('updated_at', 'asc')
                            ->get();
        foreach ($messages as $_key => $_val) {
            $messages[$_key]->updated_at = with(new Carbon($_val->updated_at))->setTimezone($user->timezone);
            $messages[$_key]->voice_message = $messages[$_key]->message;
            if ($user->smiles == 'true')
                $messages[$_key]->message = Messages::smileys(e($_val->message));
            else
                $messages[$_key]->message = e($_val->message);
        }
                
        return response()->json($messages); 
    }
    
}