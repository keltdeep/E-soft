<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function userData() {

        $users = User::all();

        return json_encode($users);
    }


}
