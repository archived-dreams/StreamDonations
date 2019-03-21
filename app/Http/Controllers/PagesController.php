<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Mail;

class PagesController extends Controller
{
    
    var $view = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Static Pages
     */
    
    public function getStatic(Request $request, $slug)
    {
        $page = basename($slug);
        $this->view['content'] = Storage::get("pages/" . \Lang::locale() . "/{$page}.html");
        if (!$this->view['content'])
            abort(404);
        $this->view['slug'] = $page;
        $this->view['title'] = trans("pages.static.{$page}.title");
        return view('pages.static', $this->view);
    }
    
    public function postStatic(Request $request, $slug)
    {
        $this->middleware('admin');
        $page = basename($slug);
        Storage::put("pages/" . \Lang::locale() . "/{$page}.html", $request->content);
        return response()->json(['success'=> trans('pages.static.saved')]);
    }
    
    /*
     * Contact Page
     */
    
    public function getContact()
    {
        $this->view['title'] = trans("pages.contact.title");
        return view('pages.contact', $this->view);
    }
    
    public function postContact(Request $request)
    {
                
        $this->validate($request, [
            'from' => [ 'required' ],
            'email' => [ 'required', 'email' ],
            'subject' => ['required', 'min:10', 'max:55'],
            'category' => ['required', 'in:' . implode(',', array_keys(trans('pages.contact.categories'))) ],
            'description' => ['required', 'min:50', 'max:10240']
        ]);
        
        $this->view = $request->only(['from', 'email', 'subject', 'category', 'description']);
        $this->view['title'] = e($request->get('subject'));
        $this->view['user_id'] = (Auth::user())['id'];
        
        $GLOBALS['_request'] = &$request;
        dd(Mail::send('emails.contact', $this->view, function ($message)
        {
            $request = &$GLOBALS['_request'];
            $message->from($request->get('email'), $request->get('from'));
            $message->to(config('app.contact_email'))->cc($request->get('email'));
            $message->subject('[' . trans('pages.contact.categories.' . $request->get('category')) . '] ' . $request->get('subject'));

        }));
        unset($GLOBALS['_request']);
        return response()->json(['success'=> trans('pages.static.sent')]);
    }
    
    
}