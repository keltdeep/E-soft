<?php

namespace App\Http\Controllers;

use App\Image;
use App\Slave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SlaveController extends Controller
{
    protected $slaves;

    public function __construct(Slave $slaves)
    {
        $this->slaves = $slaves;
    }

    public function edit($id)
    {
//
////        var_dump($_SERVER);
////        die();
        if ($_SERVER["REQUEST_URI"] === "/slave/$id/edit") {
            $slave =
                DB::table('slaves')
                    ->where('id', $id)
                    ->first();
            $slave = (array)$slave;

//            $slave = slave::query()->findOrFail($id);

            return view('slaveEdit', compact('slave'));
        }
//
////            $slave = DB::select('select * from slaves where id = ?', [$id]);
//        $slave =
//            DB::table('slaves')
//                ->where('id', $id)
//                ->first();
//
//        $data = array();
//
//        if ($_GET['agility'] !== "") {
//            $data['agility'] = $_GET['agility'] + $slave->agility;
//        } else if ($_GET['agility'] == "") {
//            $data['agility'] = $slave->agility;
//        }
//
//        if ($_GET['intelligence'] !== "") {
//            $data['intelligence'] = $_GET['intelligence'] + $slave->intelligence;
//        } else if ($_GET['intelligence'] == "") {
//            $data['intelligence'] = $slave->intelligence;
//        }
//        $k = 1.8;
//        $data['cost'] = ($data['agility'] * 0.8 + $data['intelligence'] * 0.2) * $k;
////        var_dump($data['cost']);
//        $data['rateComfort'] = $data['cost'] * $k;
//        $data['dailyExpenses'] = $data['rateComfort'] / 15;
//
//
//        DB::table('slaves')->where('id', $id)->update($data);
//
//        $slave =
//            DB::table('slaves')
//                ->where('id', $id)
//                ->first();
//        $slave = (array)$slave;
//
//
//        return redirect()->route('slave.show', [$id]);
    }

    public function create()
    {


        return view('createSlave');

    }

    public function index()
    {
        $slaves = DB::table('slaves')->simplePaginate(3);
        return View::make('slaves', ['slaves' => $slaves]);
//        $slaves = Slave::all();
//
//        $slavesArray = $slaves->toArray();


//
//        $slavesArray =  json_decode($slaves);

//        $result = json_encode(($slavesArray),TRUE);
//        $results= [];
//        foreach ($slavesArray as $slaveArray){
//            array_push($results, $slaveArray->name);
//        }

//var_dump($slavesArray['0']['name']);
//die();


//        return view('slaves', ['slaves' => $slavesArray]);

    }

    public function store()
    {
        $serverName = $_SERVER["HTTP_HOST"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';
//        $slave['id'] = filter_var($_POST['id']);
        $k = 1.8;
        $slave['name'] = filter_var($_POST['name']);
        $slave['agility'] = filter_var($_POST['agility'], FILTER_VALIDATE_INT);
        $slave['intelligence'] = filter_var($_POST['intelligence'], FILTER_VALIDATE_INT);
        $slave['cost'] = $slave['agility'] * 0.8 + $slave['intelligence'] * 0.2;
        $slave['rateComfort'] = $slave['cost'] * $k;
        $slave['dailyExpenses'] = $slave['rateComfort'] / 15;

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {

            $folder = $uploadFolder;
            $file_path = Image::upload_image($_FILES["image"], $folder);
            $file_path_exploded = explode("/", $file_path);
            $filename = $file_path_exploded[count($file_path_exploded) - 1];
            $file_url = "//$serverName/uploads/" . $filename;
            $gladiator["image"] = $file_url;
        }


        DB::table('slaves')->insert($slave);
        $slaveGet = Slave::all();
        $slavesArray = $slaveGet->toArray();
//        var_dump($slavesArray['0']);
//        die();
        foreach ($slavesArray as $key => $value) {
            if ($value['name'] == $slave['name']) {
//                var_dump($value['name'], $slave['name']);
//                return redirect()->route('slave.show', [$slavesArray['0']['id']]);
                $id = intval($value['id']);

                view('slaveView', ['slave' => $value]);
                return redirect()->route('slave.show', [$id]);

            }
        }
    }




    public function show($id)
    {

        $slave = Slave::query()->findOrFail($id);

        return view('slaveView', compact('slave'));
    }


    public function update($id)
    {
        $serverName = $_SERVER["HTTP_HOST"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        $uploadFolder = $documentRoot . '/uploads';

        if ($_SERVER["REQUEST_URI"] === "/slave/$id/edit") {
            $slave =
                DB::table('slaves')
                    ->where('id', $id)
                    ->first();
            $slave = (array)$slave;

//            $slave = slave::query()->findOrFail($id);

            return view('slaveEdit', compact('slave'));
        }

//            $slave = DB::select('select * from slaves where id = ?', [$id]);
        $slave =
            DB::table('slaves')
                ->where('id', $id)
                ->first();

        $data = array();

        if ($_POST['agility'] !== "") {
            $data['agility'] = $_POST['agility'] + $slave->agility;
        } else if ($_POST['agility'] == "") {
            $data['agility'] = $slave->agility;
        }

        if ($_POST['intelligence'] !== "") {
            $data['intelligence'] = $_POST['intelligence'] + $slave->intelligence;
        } else if ($_POST['intelligence'] == "") {
            $data['intelligence'] = $slave->intelligence;
        }
//            foto
//        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
//
//            $folder = $uploadFolder;
//            $file_path = Image::upload_image($_FILES["image"], $folder);
//            $file_path_exploded = explode("/", $file_path);
//            $filename = $file_path_exploded[count($file_path_exploded) - 1];
//            $file_url = "//$serverName/uploads/" . $filename;
//            $data["image"] = $file_url;
//        }

        $k = 1.8;

        $data['cost'] = ($data['agility'] * 0.8 + $data['intelligence'] * 0.2) * $k;
//        var_dump($data['cost']);
        $data['rateComfort'] = $data['cost'] * $k;
        $data['dailyExpenses'] = $data['rateComfort'] / 15;


        DB::table('slaves')->where('id', $id)->update($data);

//        $slave =
//            DB::table('slaves')
//                ->where('id', $id)
//                ->first();
//        $slave = (array)$slave;


        return redirect()->route('slave.show', [$id]);
    }
    public function buy($id) {
        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
        $data['master'] = $idSession;
        DB::table('slaves')->where('id', $id)->update($data);

        $user =
            DB::table('users')
                ->where('id', $idSession)
                ->first();

        $slave =
            DB::table('slaves')
                ->where('id', $id)
                ->first();

        $dataChange['money'] = $user->money - $slave->cost;

        DB::table('users')->where('id', $idSession)->update($dataChange);
//            var_dump($gladiator, $user);
//            die();
    }


}
