<?php

namespace App\Http\Controllers\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\EventlistSettings;
use App\Messages;
use App\User;

class EventlistController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getWidget', 'getWidgetData']]);
    }

    public function getHome()
    {
        $this->view['settings'] = EventlistSettings::user(Auth::user()->id);
        $this->view['title'] = trans('widgets.eventlist.home.title');
        
        return view('widgets.eventlist.home', $this->view);
    }
    
    public function postHome(Request $request)
    {
        $this->validate($request, [
            'limit' => [ 'required', 'in:10,25,50,100' ],
            'theme' => ['required', 'in:standard,dark'],
            'message_status' => ['required', 'array', 'min:1', 'in:success,user'],
        ]);
        
        $data = $request->only(['limit', 'theme', 'message_status']);
        $data['message_status'] = implode('|', $data['message_status']);
        if ($request->{'new-token'}) {
            $data['token'] = str_random(45);
            $result['widget'] = route('widgets.eventlist.widget', [ 'token' => $data['token']]);
        }
        EventlistSettings::where('user_id', Auth::user()->id)->update($data);
        $result['success'] = trans('widgets.success');
        
        return response()->json($result);
    }
    
    public function getWidget(Request $request, $token)
    {
        $this->view['settings'] = EventlistSettings::where('token', $token)->first();
        if (!$this->view['settings'])
            abort(403);
        $this->view['title'] = trans('widgets.eventlist.widget.title');
        
        return view('widgets.eventlist.widget', $this->view);
    }
    
    public function getWidgetData(Request $request, $token)
    {
        $return['settings'] = EventlistSettings::where('token', $token)->first();
        if (!$return['settings'])
            abort(403);
        $user = User::select(['timezone', 'smiles'])->where('id', $return['settings']->user_id)->first();
        $return['messages'] = Messages::select(['id', 'name', 'message', 'amount' , 'updated_at'])
                ->where('user_id', $return['settings']->user_id)
                ->whereIn('status', explode('|', $return['settings']->message_status))
                ->limit($return['settings']->limit)
                ->orderBy('updated_at', 'desc')
                ->get();
        foreach ($return['messages'] as $_key => $_val) {
            $return['messages'][$_key]->updated_at = with(new Carbon($_val->updated_at))->setTimezone($user->timezone);
            if ($user->smiles == 'true')
                $return['messages'][$_key]->message = Messages::smileys(e($_val->message));
            else
                $return['messages'][$_key]->message = e($_val->message);
        }
                
        return response()->json($return); 
    }
    
}