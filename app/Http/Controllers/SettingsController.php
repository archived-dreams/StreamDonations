<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Settings;

class SettingsController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAccount()
    {
        $this->view['title'] = trans('settings.account.title');
        return view('settings.account', $this->view);
    }
    
    public function postAccount(Request $request)
    {
        $this->validate($request, [
            'timezone' => [ 'required', 'timezone' ],
            'smiles' => ['required', 'in:true,false'],
            'links' => ['required', 'in:true,false'],
            'black_list_words' => [],
        ]);
        
        $data = $request->only(['timezone', 'smiles', 'links', 'black_list_words']);
        Auth::user()->update($data);
        return response()->json(['success'=> trans('settings.account.success')]);
    }
    
    public function getDonation()
    {
        $this->view['settings'] = Settings::user(Auth::user()->id);
        $this->view['patterns'] = Storage::disk('public')->allFiles('backgrounds/patterns');
        $this->view['title'] = trans('settings.donation.title');
        return view('settings.donation', $this->view);
    }
    
    public function postDonation(Request $request)
    {
        $this->validate($request, [
            'amount_minimum' => [ 'required', 'integer', 'min:0.01', 'max:1000000' ],
            'max_message_length' => [ 'required', 'integer', 'min:1', 'max:512' ],
            'amount_placeholder' => [ 'required', 'integer', 'min:0.01', 'max:1000000' ],
            'button_color' => [ 'required', 'color' ],
            'memo' => [ ],
            'donation_banner' => [ 'nullable', 'image' ],
            'paypal' => [ 'nullable', 'email' ],
            'background_file' => [ 'nullable', 'image' ]
        ]);
        $settings = Settings::user(Auth::user()->id);
        $data = $request->only(['paypal', 'amount_minimum', 'max_message_length', 'amount_placeholder', 'button_color', 'memo']);
        
        // Background
        if ($request->hasFile('background_file')) {
            if (stristr($settings['background'], 'patterns/') === FALSE)
                Storage::disk('public')->delete('backgrounds/' . $settings['background']);
            $filename = str_random(30) . '.' . $request->background_file->extension();
            $request->background_file->storeAs('backgrounds', $filename, 'public'); 
            $data['background'] = $filename;
        } else if (stristr($request->background, 'patterns/')) {
            if (Storage::disk('public')->exists('backgrounds/patterns/' . basename($request->background))) {
                if (stristr($settings['background'], 'patterns/') === FALSE)
                    Storage::disk('public')->delete('backgrounds/' . $settings['background']);
                $data['background'] = $request->background;
            } else
                return response()->json(['danger' => ['background' => [trans('settings.donation.background_error')]]]);
        }
        // Banner
        if ($request->hasFile('donation_banner')) {
            if ($settings['banner'] != 'banners/default.jpg')
                Storage::disk('public')->delete('banners/' . $settings['banner']);
            $filename = str_random(30) . '.' . $request->donation_banner->extension();
            $request->donation_banner->storeAs('banners', $filename, 'public'); 
            $data['banner'] = $filename;
        }
        
        Auth::user()->settings()->where('user_id', Auth::user()->id)->update($data);
        return response()->json(['success'=> trans('settings.donation.success')]);
    }
    
}