<?php

namespace App\Http\Controllers\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\DonationgoalSettings;
use Carbon\Carbon;
use App\Messages;
use App\User;
use App\Fonts;

class DonationgoalController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getWidget', 'getWidgetData']]);
    }

    public function getHome()
    {
        $this->view['title'] = trans('widgets.donationgoal.home.title');
        $this->view['settings'] = DonationgoalSettings::user(Auth::user()->id);
        $this->view['fonts'] = Fonts::get();
        return view('widgets.donationgoal.home', $this->view);
    }
    
    public function postHome(Request $request)
    {
        
        $this->validate($request, [
            'title' => [ 'required', 'max: 128' ],
            'goal_amount' => [ 'required', 'integer', 'min:0.01' ],
            'manual_goal_amount' => [ 'required', 'integer', 'min:0.01' ],
            'layout' => [ 'required', 'in:standard,condensed' ],
            'background_color' => [ 'required', 'color' ],
            'font_color' => [ 'required', 'color' ],
            'bar_text_color' => [ 'required', 'color' ],
            'bar_color' => [ 'required', 'color' ],
            'bar_background_color' => [ 'required', 'color' ],
            'bar_thickness' => [ 'required', 'integer', 'min:32', 'max:128' ],
            'font' => [ 'required', Rule::in( Fonts::keys() ) ]
        ]);
        
        $settings = DonationgoalSettings::user(Auth::user()->id);
        $data = $request->only([
            'title', 'goal_amount', 'manual_goal_amount', 'layout', 
            'background_color', 'font_color', 'bar_text_color', 'bar_color', 
            'bar_background_color', 'bar_thickness', 'font'
            ]);
            
        if ($request->new_goal == 'true') {
            $data['created_at'] = Carbon::now();
            $result['created_at'] = &$data['created_at'];
        }

        if ($request->{'new-token'}) {
            $data['token'] = str_random(45);
            $result['widget'] = route('widgets.donationgoal.widget', [ 'token' => $data['token']]);
        }
        
        DonationgoalSettings::where('user_id', Auth::user()->id)->update($data);
        $result['success'] = trans('widgets.success');
        
        return response()->json($result);
    }
    
    public function getWidget(Request $request, $token)
    {
        $this->view['settings'] = DonationgoalSettings::where('token', $token)->first();
        $this->view['title'] = null;
        if (!$this->view['settings'])
            abort(403);

        return view('widgets.donationgoal.widget-' . $this->view['settings']['layout'], $this->view);
    }
    
    public function getWidgetData(Request $request, $token)
    {
        $result['settings'] = DonationgoalSettings::where('token', $token)->first();
        if (!$result['settings'])
            abort(403);

        $result['amount'] = Messages::where('view_status', 'false')
                            ->where('user_id', $result['settings']->user_id)
                            ->whereIn('status', ['success', 'user'])
                            ->where('updated_at', '>=', $result['settings']->created_at)
                            ->sum('amount');
                
        return response()->json($result); 
    }
    
}