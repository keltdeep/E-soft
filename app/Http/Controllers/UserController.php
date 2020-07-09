<?php


namespace App\Http\Controllers;

use App\Gladiator;
use App\Image;
use App\Slave;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    public function userImage()
    {

//        $serverName = $_SERVER["HTTP_HOST"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';

        $data = array();

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {

            $folder = $uploadFolder;
            $file_path = Image::upload_image($_FILES["image"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
//            $file_url = "//$serverName/uploads/" . $filename;
            $data["image"] = "/uploads/" . $filename;
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
            if ($user !== null) {
                if (mt_rand(0, 130) >= 20/($value->strength + $value->agility + $value->heals)) {
                    $dataGladiators['money'] = $user->money + $value->rate;
                    $dataGladiators['rating'] = $user->rating + $value->cost * $k;

                    User::getUser($value->master)->update($dataGladiators);
                }

                else {
                    $dataDeath['master'] = -1;
                    Gladiator::getGladiator($value->id)->update($dataDeath);
                }
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

            if($_POST['email'] !== '') {
                $data['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            }

            if($_POST['password'] !== '') {
                $data['password'] = HASH::make(filter_var($_POST['password']));
            }

        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {

            $folder = $uploadFolder;
            $file_path = Image::upload_image($_FILES["image"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
//            $file_url = "//$serverName/uploads/" . $filename;
            $data["image"] = "/uploads/" . $filename;
        }

        User::getUser($id)->update($data);

            return redirect()->route('user.show');

    }

    public function usersList () {

        $users = DB::table('users')
            ->orderByDesc('rating')
            ->simplePaginate(3);

        $currentUser = User::currentUser();

        return view('usersList', compact(['users', 'currentUser']));
    }


    public function admRights () {

        $data =[];
        if(isset($_POST['administration']) === true) {

            $data['administration'] = true;
        } else {
            $data['administration'] = false;
        }

        User::getUser($_POST['id'])->update($data);

        return redirect('users');
    }



}
