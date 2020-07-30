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
        $user = User::currentUser();

//        $value = Session::all();
//        $id = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
//
//
//        $user = User::query()->findOrFail($id);
//
//        var_dump($user->value('name'));
//        die();
        $gladiatorsRate = DB::table('gladiators')
            ->where([['master', $user->id], ['arena', '=', null]])
            ->orWhere([['master', $user->id], ['arena', '!=', '-1']])
            ->get('rate');


        $slavesRate = DB::table('slaves')
            ->where('master', $user->id)
            ->get('dailyExpenses');

        $dataGladiators = [];

        for ($i = 0; $i < count($gladiatorsRate); $i++) {
                array_push($dataGladiators, $gladiatorsRate[$i]->rate);
    }
            $dataSlaves = [];

            for ($i = 0; $i < count($slavesRate); $i++) {
                    array_push($dataSlaves, $slavesRate[$i]->dailyExpenses);
            }

            $data = array_sum($dataGladiators) - array_sum($dataSlaves);

        return view('home', compact('user', 'data'));
    }
    public function description () {
        return view('description');
    }
}
