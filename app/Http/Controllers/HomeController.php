<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        
        dd(Str::slug('Laravel 5 Framework', '-'));
        return view('home');
        // Auth::attempt();

        // return redirect()->route('posts.index');
    }
}
