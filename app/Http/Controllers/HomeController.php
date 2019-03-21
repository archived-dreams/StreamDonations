<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Messages;

class HomeController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        //
    }

    public function getHome()
    {
        // Guest
        if (!Auth::user()) {
            $this->view['title'] = trans('home.landing.title');
            return view('home.landing', $this->view);
        }
        
        // Dashboard
        $messages = Messages::select('updated_at', 'amount')
                            ->where('user_id', Auth::user()->id)
                            ->where('status', 'success')
                            ->where('updated_at', '>=', Carbon::now()->subWeek()->startOfDay())
                            ->where('updated_at', '<=', Carbon::now())
                            ->get();
        
        
        // Days
        for (
            $date = Carbon::now()->subWeek()->startOfDay(); 
            $date->lte(Carbon::now()->setTimezone(Auth::user()->timezone)); 
            $date->addDay()
            ) {
            $messageStatistics[$date->toDateString()] = 0;
            $messageDates[] = $date->toDateString();
        }

        // Amount
        foreach ($messages as $message) {
            $date = with(new Carbon($message->updated_at))->toDateString();
            $messageStatistics[$date] += $message->amount;
        }

        $this->view['messageStatistics'] = array_values($messageStatistics);
        $this->view['messageDates'] = array_values($messageDates);
        
        $this->view['title'] = trans('home.dashboard.title');
        return view('home.dashboard', $this->view);
        
        
    }
    
}