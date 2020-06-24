<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use App\Gladiator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Image;

//use function MongoDB\BSON\toJSON;

class GladiatorController extends Controller

{
    protected $gladiators;
//    public function checkAttributes($attributes, $gladiator) {
//        if($attributes !== "") {
//            $attributes = $attributes + $gladiator;
//        }
//    }
    public function __construct(Gladiator $gladiators)
    {
        $this->gladiators = $gladiators;
    }

    // public function getGladiator() {


    // }
    public function edit($id)
    {



//        var_dump($_SERVER);
//        die();
        if($_SERVER["REQUEST_URI"] === "/gladiator/$id/edit") {
            $gladiator =
                DB::table('gladiators')
                    ->where('id', $id)
                    ->first();
            $gladiator = (array)$gladiator;


//            $gladiator = Gladiator::query()->findOrFail($id);

            return view('gladiatorEdit', compact('gladiator'));
        }
//
////            $gladiator = DB::select('select * from gladiators where id = ?', [$id]);
//        $gladiator =
//            DB::table('gladiators')
//                ->where('id', $id)
//                ->first();
//
//        $data = array();
//
//        if ($_GET['strength'] !== "") {
//            $data['strength'] = $_GET['strength'] + $gladiator->strength;
//        }
//            else if ($_GET['strength'] == "") {
//                $data['strength'] = $gladiator->strength;
//        }
//
//        if ($_GET['agility'] !== "") {
//            $data['agility'] = $_GET['agility'] + $gladiator->agility;
//        }
//            else if ($_GET['agility'] == "") {
//                $data['agility'] = $gladiator->strength;
//        }
//
//        if ($_GET['heals'] !== "") {
//            $data['heals'] = $_GET['heals'] + $gladiator->heals;
//        }
//            else if ($_GET['heals'] == "") {
//                $data['heals'] = $gladiator->heals;
//        }
//
//
//        $k = 1.1;
//
//        $data['cost'] = ($data['strength'] * 0.5 + $data['agility'] * 0.3 + $data['heals'] * 0.2) * $k * 1.5;
////        var_dump($data['cost']);
//        $data['rate'] = $data['cost'] / 7;
//
//
//        DB::table('gladiators')->where('id', $id)->update($data);
//
//        $gladiator =
//            DB::table('gladiators')
//                ->where('id', $id)
//                ->first();
//        $gladiator = (array)$gladiator;
//
//
//
//        return redirect()->route('gladiator.show', [$id]);
    }

    public function create()
    {


        return view('createGladiator');

    }

    public function index()
    {

        $gladiators = DB::table('gladiators')->simplePaginate(3);
        return View::make('gladiators', ['gladiators' => $gladiators] );
//

    }

    public function store()
    {
//        $serverName = $_SERVER["HTTP_HOST"];
//        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
//        $uploadFolder = $documentRoot.'/uploads';
        $serverName = $_SERVER["HTTP_HOST"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';
//        $gladiator['id'] = filter_var($_POST['id']);
        $gladiator['name'] = filter_var($_POST['name']);
        $gladiator['strength'] = filter_var($_POST['strength'], FILTER_VALIDATE_INT);
        $gladiator['agility'] = filter_var($_POST['agility'], FILTER_VALIDATE_INT);
        $gladiator['heals'] = filter_var($_POST['heals'], FILTER_VALIDATE_INT);


        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {

            $folder = $uploadFolder;
            $file_path = Image::upload_image($_FILES["image"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
            $file_url = "//$serverName/uploads/" . $filename;
            $gladiator["image"] = $file_url;
        }

        $k = 1.1;

        $gladiator['cost'] = ($gladiator['strength'] * 0.5 + $gladiator['agility'] * 0.3 + $gladiator['heals'] * 0.2) * $k * 1.5;
        $gladiator['rate'] = $gladiator['cost'] / 7;


        DB::table('gladiators')->insert($gladiator);
        $gladiatorGet = Gladiator::all();
        $gladiatorsArray = $gladiatorGet->toArray();
//        var_dump($gladiatorsArray['0']);
//        die();
        foreach ($gladiatorsArray as $key => $value) {
            if($value['name'] == $gladiator['name']){
//                var_dump($value['name'], $gladiator['name']);
//                return redirect()->route('gladiator.show', [$gladiatorsArray['0']['id']]);
                $id = intval($value['id']);
//var_dump($value);
//die();
                view('gladiatorView', ['gladiator' => $value]);
                return redirect()->route('gladiator.show', [$id]);

            }
        }

//        $gladiator = (array)$gladiator;
//        var_dump($gladiatorsArray['0']['name']);
//        die();

//        DB::insert('insert into gladiators (name, strength, agility, heals, cost, rate) values (?, ?, ?, ?, ?, ?)', [$gladiator['*']]);


//        header("Location: /gladiator/$name");

//       return GladiatorController::show($gladiator);
//        return View::make('gladiatorView', $gladiatorArray);
//        return redirect()->route('gladiator.show', [$id]);

//        return view('gladiatorView', ['gladiator' => $gladiator]);
    }

    public function show($id)
    {

        $gladiator = Gladiator::query()->findOrFail($id);

        return view('gladiatorView', compact('gladiator'));
    }



    public function update($id)
    {
//        $serverName = $_SERVER["HTTP_HOST"];
//        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
//        $uploadFolder = $documentRoot . '/uploads';
//        var_dump($_FILES);
//            die();
//        $gladiator['id'] = filter_var($_POST['id']);


//


        if($_SERVER["REQUEST_URI"] === "/gladiator/$id/edit") {
            $gladiator =
                DB::table('gladiators')
                    ->where('id', $id)
                    ->first();
            $gladiator = (array)$gladiator;


//            $gladiator = Gladiator::query()->findOrFail($id);

            return view('gladiatorEdit', compact('gladiator'));
        }



//            $gladiator = DB::select('select * from gladiators where id = ?', [$id]);
        $gladiator =
            DB::table('gladiators')
                ->where('id', $id)
                ->first();

        $data = array();

        if ($_POST['strength'] !== "") {
            $data['strength'] = $_POST['strength'] + $gladiator->strength;
        }
        else if ($_POST['strength'] == "") {
            $data['strength'] = $gladiator->strength;
        }

        if ($_POST['agility'] !== "") {
            $data['agility'] = $_POST['agility'] + $gladiator->agility;
        }
        else if ($_POST['agility'] == "") {
            $data['agility'] = $gladiator->strength;
        }

        if ($_POST['heals'] !== "") {
            $data['heals'] = $_POST['heals'] + $gladiator->heals;
        }
        else if ($_POST['heals'] == "") {
            $data['heals'] = $gladiator->heals;
        }

//       добавление фотки
//        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
//
//            $folder = $uploadFolder;
//            $file_path = Image::upload_image($_FILES["image"], $folder);
//            $file_path_exploded = explode("/", $file_path);
//            $filename = $file_path_exploded[count($file_path_exploded) - 1];
//            $file_url = "//$serverName/uploads/" . $filename;
//            $data["image"] = $file_url;
//        }


        $k = 1.1;

        $data['cost'] = ($data['strength'] * 0.5 + $data['agility'] * 0.3 + $data['heals'] * 0.2) * $k * 1.5;
//        var_dump($data['cost']);
        $data['rate'] = $data['cost'] / 7;


        DB::table('gladiators')->where('id', $id)->update($data);

//        $gladiator =
//            DB::table('gladiators')
//                ->where('id', $id)
//                ->first();
//        $gladiator = (array)$gladiator;



        return redirect()->route('gladiator.show', [$id]);
//        $gladiator['cost'] = $gladiator['strength'] * $gladiator['agility'] * $gladiator['heals'];
//        $gladiator['rate'] = $gladiator['cost'] * 10;


        }
        public function buy($id) {
            $value = Session::all();
            $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
            $data['master'] = $idSession;
            DB::table('gladiators')->where('id', $id)->update($data);

            $user =
                DB::table('users')
                    ->where('id', $idSession)
                    ->first();

            $gladiator =
                DB::table('gladiators')
                    ->where('id', $id)
                    ->first();

            $dataChange['money'] = $user->money - $gladiator->cost;

            DB::table('users')->where('id', $idSession)->update($dataChange);
//            var_dump($gladiator, $user);
//            die();
        }

    }






