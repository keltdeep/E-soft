<?php

namespace App\Http\Controllers;

//use Illuminate\Contracts\Session\Session;
use App\Gladiator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $value = Session::all();
        $id = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
        $user = User::query()->findOrFail($id);

        return view('home', compact('user'));
    }
}
