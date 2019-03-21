<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Messages;
use App\Settings;
use App\User;
use App\PayoutSettings;
use App\Payouts;

class PayoutsController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getHome()
    {
        $this->view['title'] = trans('payouts.title');
        $this->view['payouts'] = Payouts::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        foreach ($this->view['payouts'] as $key => $row) {
            $this->view['payouts']->$key = $row->created_at ? with(new Carbon($row->created_at))->setTimezone(Auth::user()->timezone) : '';
        }
        $settings = PayoutSettings::withTrashed()->get();
        $this->view['settings'] = [];
        foreach ($settings as $billing) {
            $this->view['settings'][$billing['id']] = $billing;
        }
        return view('payouts.home', $this->view); 
    } 
    
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'billing_system' => [ 'required', 'in:' . PayoutSettings::validate_list() ],
        ]);
        
        $billing = PayoutSettings::where('id', $request->billing_system)->first();
        
        if (Auth::user()->balance < $billing->max_amount)
            $billing->max_amount = Auth::user()->balance;
        
        $this->validate($request, [
            'amount' => [ 'required', 'numeric', 'min:' . $billing->min_amount, 'max:' . $billing->max_amount ],
            'purse' => [ 'required', 'regex:' . $billing->purse_regex ]
        ]);

        $data = $request->only(['billing_system', 'amount', 'purse']);
        $data['commission'] = ($request->amount / 100 * $billing->percent_commission) + $billing->fixed_commission;
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'wait';
        
        if ($data['commission'] >= Auth::user()->balance || $data['amount'] > Auth::user()->balance)
            return response()->json(['danger'=> trans('payouts.fatal')]);
        
        Payouts::create($data);
        Auth::user()->update([ 'balance' => Auth::user()->balance - $data['amount'] ]);
        
        return response()->json(['success'=> trans('payouts.created')]);
    }
    
}