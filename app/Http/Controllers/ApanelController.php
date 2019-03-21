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
use App\Configuration;

class ApanelController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('admin');
    }

    
    /**
     * Configurations
     */
    public function getConfigurations()
    {
        $configs = Configuration::orderBy('key', 'desc')->get();
        $this->view['data'] = [];
        foreach ($configs as $config)
            $this->view['data'][$config->key] = $config->value;
        
        $this->view['title'] = trans('apanel.configurations.title');
        return view('apanel.configurations', $this->view);
    }
    
    public function postConfigurations(Request $request)
    {
        
        $configurations = $request->all();
        foreach ($configurations as $key => $val) {
            if (base64_encode(base64_decode($key)) !== $key)
                continue;
            $key = base64_decode($key);
            $configuration = Configuration::where('key', $key)->first();
            if (!$configuration || $configuration->value == $val)
                continue;
            Configuration::where('key', $key)->update(['value' => $val]);
        }
        Configuration::reload();
        return response()->json(['success'=> trans('apanel.configurations.success')]);
    }
    
    
    /**
     * Statistics
     */

    public function getStatistics()
    {
        
        /* Lat week messages */
        $messages = Messages::withTrashed()
                            ->select('updated_at', 'amount', 'commission')
                            ->where('status', 'success')
                            ->where('updated_at', '>=', Carbon::now()->subWeek()->startOfDay())
                            ->where('updated_at', '<=', Carbon::now())
                            ->get();
        
        // Days
        for (
            $date = Carbon::now()->subWeek()->startOfDay()->setTimezone(Auth::user()->timezone); 
            $date->lte(Carbon::now()->setTimezone(Auth::user()->timezone)); 
            $date->addDay()
            ) {
            $messageDates[] = $date->toDateString();
            $messageStatistics['amount'][$date->toDateString()] = 0;
            $messageStatistics['commission'][$date->toDateString()] = 0;
        }

        // Amount
        foreach ($messages as $message) {
            $date = with(new Carbon($message->updated_at))->setTimezone(Auth::user()->timezone)->toDateString();
            $messageStatistics['amount'][$date] += $message->amount;
            $messageStatistics['commission'][$date] += $message->commission;
        }

        $this->view['messageDates'] = &$messageDates;
        $this->view['messageStatistics'] = [
            'amount' => array_values($messageStatistics['amount']),
            'commission' => array_values($messageStatistics['commission'])
        ];
        
        /* Count messages */
        $this->view['counters']['paid_messages'] = Messages::where('status', 'success')->count();
        $this->view['counters']['messages'] = Messages::count();
        $this->view['counters']['amount'] = Messages::withTrashed()->where('status', 'success')->sum('amount');
        $this->view['counters']['commission'] = Messages::withTrashed()->where('status', 'success')->sum('commission');
        $this->view['counters']['refunds'] = Messages::withTrashed()->where('status', 'refund')->count();
        $this->view['counters']['amount_refunds'] = Messages::withTrashed()->where('status', 'refund')->sum('amount');
        $this->view['counters']['users'] = User::count();
        $this->view['counters']['today_users'] = User::where('created_at', '>=', Carbon::today())->count();
        
        $this->view['title'] = trans('apanel.statistics.title');
        return view('apanel.statistics', $this->view);
    }
    
    /**
     * Donations
     */
    public function getDonations()
    {
        $this->view['title'] = trans('apanel.donations.title');
        return view('apanel.donations', $this->view);
    }
    
    public function getDonationsData()
    {
        return Datatables::eloquent(Messages::select(['updated_at', 'user_id', 'name', 'amount', 'commission', 'message', 'id', 'status', 'billing_system'])->withTrashed()->whereIn('status', ['success', 'refund']))
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at ? with(new Carbon($data->updated_at))->setTimezone(Auth::user()->timezone) : '';
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount, 2, '.', '');
            })
            ->editColumn('commission', function ($data) {
                return number_format($data->commission, 2, '.', '');
            })
            ->editColumn('message', function ($data) {
                if (Auth::user()->smiles == 'true')
                    return Messages::smileys($data->message);
                else
                    return $data->message;
            })->editColumn('user_id', function ($data) {
                $user = User::where('id', $data->user_id)->first();
                return '<a href="' . route("apanel.users.edit", ["id" => $data->user_id]) . '">' . $user->name . '</a>';
            })->make(true);
    }
    
    /**
     * Users
     */
    public function getUsers()
    {
        $this->view['title'] = trans('apanel.users.title');
        return view('apanel.users', $this->view);
    }
    
    public function getUsersData()
    {
        return Datatables::eloquent(User::select(['id', 'name', /*'balance',*/ 'email', 'timezone', 'avatar', 'token', 'created_at']))
            ->editColumn('created_at', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->setTimezone(Auth::user()->timezone) : '';
            })/*->editColumn('balance', function ($data) {
                return number_format($data->balance, 2, '.', '');
            })*/->make(true);
    }
    
    public function getUsersEdit(Request $request, $id)
    {
        $this->view['user'] = User::where('id', $id)->first();
        if (!$this->view['user'])
            abort(404);
        $this->view['title'] = trans('apanel.users.edit.title', [ 'id' => $this->view['user']->id ]);
        return view('apanel.users_edit', $this->view);
    }
    
    public function postUsersEdit(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user)
            abort(404);

        $this->validate($request, [
            //'balance' => [ 'required', 'numeric', 'min:0', 'max:1000000' ],
            'name' => [ 'required', 'max:64' ],
            'level' => [ 'required', 'in:admin,user' ],
            'email' => [ 'nullable', 'email' ],
            'timezone' => [ 'required', 'timezone' ],
            'smiles' => ['required', 'in:true,false'],
            'links' => ['required', 'in:true,false'],
            'token' => [ 'required' ],
        ]);
        
        $data = $request->only([/*'balance',*/ 'name', 'level', 'email', 'timezone', 'smiles', 'links', 'token', 'black_list_words']);
        
        $user->update($data);
        return response()->json(['success'=> trans('settings.account.success')]);
    }
    
}