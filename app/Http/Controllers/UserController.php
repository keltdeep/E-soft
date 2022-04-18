<?php


namespace App\Http\Controllers;

use App\Gladiator;
use App\Slave;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use JD\Cloudder\Facades\Cloudder;

class UserController extends Controller
{
    public function userImage(Request $request)
    {
        $data = array();

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
            Cloudder::upload($request->file('image'));
            $cloundary_upload = Cloudder::getResult();
            $gladiator["image"] = $cloundary_upload['url'];
        }

        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
        $id = $idSession;

        User::getUser($id)->update($data);

        return redirect()->route('home', [$id]);
    }

    public function updatingIndicators()
    {
        $users = User::all();
        foreach ($users as $key => $value) {
            $data['rating'] = $value->rating = 0;

            User::getUser($value->id)->update($data);
        }

        $gladiators = Gladiator::all();
        foreach ($gladiators as $key => $value) {
            $k = 1.1;
            $user = DB::table('users')->where('id', $value->master)->first();

            if ($user !== null && $value->arena != -1) {
                $dataGladiators['money'] = $user->money + $value->rate;
                $dataGladiators['rating'] = $user->rating + $value->cost * $k;
                User::getUser($value->master)->update($dataGladiators);
            }
        }

        $slaves = Slave::all();

        foreach ($slaves as $key => $value) {
            $user = DB::table('users')->where('id', $value->master)->first();
            if ($user !== null) {
                $dataSlaves['money'] = $user->money - $value->dailyExpenses;
                $dataSlaves['rating'] = $user->rating + $value->rateComfort;

                User::getUser($value->master)->update($dataSlaves);
            }
        }

        $users = DB::table('users')
            ->orderByDesc('rating')
            ->get();

        foreach ($users as $key => $value) {
            for ($i = 0; $i < 3; $i++) {
                if ($i === 0 && $i === $key) {
                    $userMoney['money'] = $value->money + 8;
                    User::getUser($value->id)->update($userMoney);
                }

                if ($i === 1 && $i === $key) {
                    $userMoney['money'] = $value->money + 5;
                    User::getUser($value->id)->update($userMoney);
                }

                if ($i === 2 && $i === $key) {
                    $userMoney['money'] = $value->money + 3;
                    User::getUser($value->id)->update($userMoney);
                }
            }
        }

        return redirect()->route('home');
    }

    public function show()
    {
        $user = User::currentUser();

        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'unique:users|string|nullable',
            'email' => 'unique:users,email|nullable',
            'password' => 'different:old_password|min:8|nullable',
            'image' => "image"
        ]);

        $id = $_POST['id'];

        $data= [];

        if ($_POST['name'] !== '') {
            $data['name'] = filter_var($_POST['name']);
        }

        if ($_POST['email'] !== '') {
            $data['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }

        if ($_POST['password'] !== '') {
            $data['password'] = HASH::make(filter_var($_POST['password']));
        }

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
            Cloudder::upload($request->file('image'));
            $cloundary_upload = Cloudder::getResult();
            $data["image"] = $cloundary_upload['url'];
        }

        User::getUser($id)->update($data);

        return redirect()->route('user.show');
    }

    public function usersList () {
        $users = DB::table('users')
            ->orderByDesc('rating')
            ->simplePaginate(3);

        $currentUser = User::currentUser();

        $countWinners = [];
        for ($i = 0; $i < 1000; $i++) {

        $gladiators = DB::table('arenaInfo')
            ->orderByDesc('updated_at')
            ->limit(1000)
            ->get();

        $gladiators[$i] = (array) $gladiators[$i];
        $gladiatorsCount = count($gladiators);

        array_push($countWinners, $gladiators[$i]);

           if ($i + 3 < $gladiatorsCount - 1){
               $i = $i + 3;
           } else {
                $dataName = [];
                foreach ($countWinners as $key => $value) {
                    array_push($dataName, $value['name']);
                }

               $keyCount = count($dataName);
               sort($dataName);

               $data = [];

               foreach ($dataName as $key => $value) {
                   if ($key + 1 < $keyCount) {
                       if ($value == $dataName[$key + 1]) {
                           array_push($data, $value);
                       }
                       array_count_values($data);
                       sort($data, SORT_REGULAR);
                   }
               }

               $data = array_count_values($data);
               $dataCount = count($data);

               arsort($data);

               $champions = [];
               $win = null;

               foreach ($data as $key => $value) {
                   if ($win == null) {
                       $win = $value;
                   }

                   if ($value === $win) {
                       array_push($champions, $key);
                   }
               }
               $gladiators = [];
               foreach ($champions as $champion) {
                   $gladiator = DB::table('gladiators')->where('name', $champion)->get();
                   array_push($gladiators, $gladiator);
               }

               return view('usersList', compact(['users', 'currentUser', 'gladiators', 'win']));
           }
        }

        return view('usersList', compact(['users', 'currentUser', 'gladiators', 'win']));
    }


    public function admRights () {
        $data['administration'] = filter_var($_POST['administration'], FILTER_VALIDATE_BOOLEAN);

        User::getUser($_POST['id'])->update($data);

        return redirect('users');
    }
}
