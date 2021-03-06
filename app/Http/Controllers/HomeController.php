<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function home()
    {
        return view('home');
    }
    public function user_profile($id)
    {
        $user = \App\User::find($id);
        $posts =  \App\Post::all();
        return view('home.user_profile', compact("user","posts"));
    }
    public function template()
    {
        $users =  \App\User::all();
        $posts = Post::all();
        return view('layouts.template', compact("posts","users"));
    }
    function profile()
    {
        $user = \Auth::user();
        $users =  \App\User::all();
        $posts =  \App\Post::all();
        return view('home.profile', compact("user","posts","users"));
    }
    function activity()
    {
        $users =  \Auth::user()->followers()->get();
        $alluser =  \App\User::all();
        $posts =  \App\Post::all();
        return view('home.activity',compact("posts","users","alluser"));
    }
    function posting()
    {
        $posts =  \App\Post::all();
        return view('home.posting',compact("posts"));
    }
    function edit($id)
    {
       $posts =  \App\Post::all();
       $user = \App\User::find($id);
       return view('home.edit', compact("user", "posts"));
    }
    function update(Request $request, $id)
    {
        if ($file = $request->profile_image) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('uploads/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }
    
       $user = \App\User::find($id);
       $user->name = $request->name;
       $user->profile = $request->profile;
       $user->profile_image = $fileName;
       $user->save();
       return redirect("/home/profile");
    }
}