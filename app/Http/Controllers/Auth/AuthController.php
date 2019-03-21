<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'getCheck', 'getSuccess']]);
        
        // Auth methods
        $this->methods = ['youtube', 'twitch', 'mixer'];
        foreach ($this->methods as $key => $method) {
            if (config("auth.{$method}.status") == 'disabled')
                unset($this->methods[$key]);
        }
    }

    public function getLogin()
    {
        return view('auth.home', [
            'title' => trans('auth.home.title'),
        ]);
    }

    public function getCheck()
    {
        return response()->json(['status'=> !Auth::user() ? false : true]);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getSuccess()
    {
        return view('auth.success', [
            'title' => trans('auth.success.title'),
        ]);
    }

    public function getRedirect(Request $request, $slug)
    {
        if (!in_array($slug, $this->methods))
            return redirect()->route('auth')->with('danger', trans('auth.messages.method'));

        // Redirect
        if (!$request->has('code')) {
            return Socialite::with($slug)->redirect();
        }

        // Auth or create
        Socialite::with($slug)->user();
    }

    public function getCallback(Request $request, $slug)
    {
        if (!in_array($slug, $this->methods))
            return redirect()->route('login')->with('danger', trans('auth.messages.method'));

        // Redirect
        if (!$request->has('code'))
            return redirect()->route('login')->with('danger', trans('auth.messages.again'));

        // Socialite
        $socialite = Socialite::with($slug)->user();
        
        // Get user
        $user = User::where('token', $slug . '::' . $socialite->getId())->first();

        // User Data
        $user_data = [
            'name' => $socialite->getNickname() ? $socialite->getNickname() : $socialite->getName() . '',
            'email' => $socialite->getEmail() ? $socialite->getEmail() : 'no@email.com',
            'avatar' => $socialite->getAvatar() ? $socialite->getAvatar() : config('auth.default_avatar'),
            'token' =>  $slug . '::' . $socialite->getId()
        ];
        // Mixer
        if ($slug == 'mixer') {
            $user_data['name'] = $socialite->user['username'];
        }
        
        // Create user
        if (!$user) {
            
            if ($user = User::create($user_data)) {
                // Login
                Auth::login($user, true);
                return redirect()->route('auth.success')->with('success', trans('auth.messages.registered'));
            } else {
                return redirect()->route('login')->with('danger', trans('auth.messages.auth_error'));
            }
        // Login
        } else {
            // Update information
            $user->update($user_data);
            // Login
            Auth::login($user, true);
            return redirect()->route('auth.success');
        }
    }

}
