<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Messages;
use App\User;
use App\Settings;

class PaymentsController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
		//
    }
    
    public function getStatus(Request $request, $id)
    {	
		
        $this->view['message'] = Messages::where('id', $id)->first();
        if (!$this->view['message'])
            abort(403);
        $this->view['user'] = User::where('id', $this->view['message']->user_id)->first();
		$this->view['settings'] = Settings::where('user_id', $this->view['user']->id)->first();
        
        if (!in_array($this->view['message']->status, ['success', 'wait', 'refund']))
            return redirect()->route('donate', ['service' => $this->view['user']->service(), 'id' => $this->view['user']->service_id()]);
        	        
        $this->view['title'] = trans('payments.status.title');
        return view('payments.status', $this->view);
    }
    
    public function getStatusAjax(Request $request, $id)
    {
        $message = Messages::where('id', $id)->first();
        if (!$message)
            abort(403);
        return $message->status;
    }
    
}