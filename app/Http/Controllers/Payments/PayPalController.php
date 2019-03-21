<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Messages;
use App\User;
use App\Settings;
use PayPal;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Traits\IPNResponse;
use Illuminate\Support\Facades\Storage;

class PaypalController extends Controller
{
	use IPNResponse;
    var $view = [];

    public function __construct()
    {
		config('paypal.sandbox.certificate', false);
		config('paypal.live.certificate', false);
    }
	
	private function _commission($amount)
	{
		return round(($amount / 100) * config('paypal.commission'), 2);
	}
    
    public function getRedirect(Request $request, $id)
    {	
		
        $message = Messages::where('id', $id)->first();
        if (!$message)
            abort(403);
        $user = User::where('id', $message->user_id)->first();
		$settings = Settings::where('user_id', $user->id)->first();
        
        if ($message->status != 'wait' || $settings->paypal == '')
            return redirect()->route('donate', ['service' => $user->service(), 'id' => $user->service_id()]);
        		        
		$data = [];
		$data['items'] = [[
			'name' => trans('donations.donate.payment_description', [ 'name' => $user->name ]),
			'price' => $message->amount,
			'qty' => 1
		]];
		$data['invoice_id'] = $message->id;
		$data['invoice_description'] = trans('donations.donate.payment_description', [ 'name' => $user->name ]);
		$data['payer'] = 'PRIMARYRECEIVER';
		$data['return_url'] = route('payments.status', ['id' => $message->id]);
		$data['cancel_url'] = route('payments.paypal.redirect', ['id' => $message->id]);
		$data['custom'] = $message->id;
		
		$data['receivers']  = [[
				'email' => $settings->paypal,
				'amount' => $message->amount,
				'primary' => true,
			], [
				'email' => config('paypal.' . config('paypal.mode') . '.email'),
				'amount' => $this->_commission($message->amount),
				'primary' => false
		]];


		$this->gateway = PayPal::setProvider('adaptive_payments');
		$this->gateway->setCurrency(config('paypal.currency'));
		$this->gateway->addOptions([
			'BRANDNAME' => config('app.title'),
			'LOGOIMG' => asset('assets/img/logo-clean.png'),
			'CHANNELTYPE' => 'Merchant'
		]);
		
		$response = $this->gateway->createPayRequest($data);
				
		if (!isset($response['payKey']) || !$response['payKey'])
			abort(403);
		
    	$redirect_url = $this->gateway->getRedirectUrl('approved', $response['payKey']);
    	return redirect($redirect_url);
    }
    
    public function anyNotify(Request $request)
    {
		$this->provider = new ExpressCheckout();
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();
        $response = (string) $this->provider->verifyIPN($post);
        /*
		$logFile = 'public/paypal.txt';
        Storage::disk('local')->put($logFile, microtime() . "\r\n" . print_r($request->all(), true));
		*/
		if ($response !== 'VERIFIED')
			return;
		
        $message = Messages::withTrashed()->where('id', $request->get('custom'))->first();
        if (!$message)
            return;
		
		switch ($request->get('payment_status')) {
			case 'Refunded':
				$message->status = 'refund';
				$message->save();
				break;
			case 'Completed':
				$message->commission = $this->_commission($message->amount);
				$message->status = 'success';
				$message->billing_system = 'PayPal';
				$message->save();
				break;
		}

    }

    
}