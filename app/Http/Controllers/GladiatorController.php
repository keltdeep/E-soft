<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use App\Gladiator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Image;
use Illuminate\Validation\ValidationException;


class GladiatorController extends Controller

{

    public function gladiatorList()
    {

        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];

        $gladiators = DB::table('gladiators')
            ->where('master', '=', $idSession)
            ->orderBy('name')
            ->simplePaginate(3);


        return View::make('myGladiators', ['gladiators' => $gladiators]);
    }

    public function edit($id)
    {


        if ($_SERVER["REQUEST_URI"] === "/gladiator/$id/edit") {

            $gladiator = Gladiator::getGladiator($id)->first();

            $gladiator = (array)$gladiator;

            $k = 1.1;

            $gladiator['costStrength'] = $gladiator['cost'] / 10 * 0.5;
            $gladiator['costAgility'] = $gladiator['cost'] / 10 * 0.3;
            $gladiator['costHeals'] = $gladiator['cost'] / 10 * 0.2;
            $gladiator['thePossibilityOfDeath'] = 20 / ($gladiator['strength'] + $gladiator['agility'] + $gladiator['heals']) * $k;

            return view('gladiatorEdit', compact('gladiator'));
        }
        return null;
    }

    public function create()
    {
        $user = USER::currentUser();

        if ($user->administration === true) {
            return view('createGladiator');
        }
        return null;


    }

    public function index()
    {

        $gladiators = DB::table('gladiators')
            ->where('master', '=', NULL)
            ->orWhereNotNull('seller')
            ->orderBy('name')
            ->simplePaginate(3);
        return View::make('gladiators', ['gladiators' => $gladiators]);

    }

    public function store()
    {
//        Создание Гладиаторов
//        $serverName = $_SERVER["HTTP_HOST"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';

        $gladiator['name'] = filter_var($_POST['name']);
        $gladiator['strength'] = filter_var($_POST['strength'], FILTER_VALIDATE_INT);
        $gladiator['agility'] = filter_var($_POST['agility'], FILTER_VALIDATE_INT);
        $gladiator['heals'] = filter_var($_POST['heals'], FILTER_VALIDATE_INT);


        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {

            $folder = $uploadFolder;
            $file_path = Image::upload_image($_FILES["image"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
//            $file_url = "//$serverName/uploads/" . $filename;
            $gladiator["image"] = "/uploads/" . $filename;;
        }

        $k = 1.1;

        $gladiator['cost'] = ($gladiator['strength'] * 0.5 + $gladiator['agility'] * 0.3 + $gladiator['heals'] * 0.2) * $k * 1.5;
        $gladiator['rate'] = $gladiator['cost'] / 7;

        DB::table('gladiators')
            ->insert($gladiator);

        $gladiatorGet = Gladiator::all();

        $gladiatorsArray = $gladiatorGet->toArray();
        foreach ($gladiatorsArray as $key => $value) {
            if ($value['name'] == $gladiator['name']) {
                $id = intval($value['id']);
                view('gladiatorView', ['gladiator' => $value]);
                return redirect()->route('gladiator.show', [$id]);
            }
        }

        return null;
    }

    public function show($id)
    {
//        $gladiator = Gladiator::getGladiator($id)-first();

        $gladiator = Gladiator::query()->findOrFail($id);

        return view('gladiatorView', compact('gladiator'));
    }


    public function  update(Request $request, $id)
    {

        $request->validate([
            'strength' => 'numeric|between:0,1',
            'agility' => 'numeric|between:0,1',
            'heals' => 'numeric|between:0,1',
        ]);


        if ($_SERVER["REQUEST_URI"] === "/gladiator/$id/edit") {

            $gladiator = Gladiator::getGladiator($id)->first();

            $gladiator = (array)$gladiator;

            return view('gladiatorEdit', compact('gladiator'));
        }

        $gladiator = Gladiator::getGladiator($id)->first();


        $data = array();

        $user = User::currentUser();

        $data['strength'] = User::updateAttributes($data, $_POST['strength'], $_POST['costStrength'], $gladiator->strength, $user);
        $data['agility'] = User::updateAttributes($data, $_POST['agility'], $_POST['costAgility'], $gladiator->agility, $user);
        $data['heals'] = User::updateAttributes($data, $_POST['heals'], $_POST['costHeals'], $gladiator->heals, $user);


        $k = 1.1;

        $data['cost'] = ($data['strength'] * 0.5 + $data['agility'] * 0.3 + $data['heals'] * 0.2) * $k * 1.5;
        $data['rate'] = $data['cost'] / 7;

        Gladiator::getGladiator($id)->update($data);

        return redirect()->route('gladiator.show', [$id]);

    }

    public function buy($id)
    {
        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];

        $user = User::getUser($idSession)->first();
        $gladiator = Gladiator::getGladiator($id)->first();

        if ($user->money >= $gladiator->cost) {
            $data['master'] = $idSession;

            Gladiator::getGladiator($id)->update($data);

            $dataChange['money'] = $user->money - $gladiator->cost;

            User::getUser($idSession)->update($dataChange);
        } else {
            print('not enough money for buy');
            die();
        }





        if ($gladiator->seller !== null) {

            $user = User::getUser($gladiator->seller)->first();

            $changeMoneySeller['money'] = $user->money + $gladiator->cost;

            User::getUser($gladiator->seller)->update($changeMoneySeller);

            $changeGladiator['seller'] = null;

            Gladiator::getGladiator($id)->update($changeGladiator);

        }

        return redirect()->route('gladiator.show', [$id]);
    }


    public function sell($id)
    {

        $user = User::currentUser();

        $data['seller'] = $user->id;

        Gladiator::getGladiator($id)->update($data);

        return redirect()->route('gladiator.index');
    }


}






