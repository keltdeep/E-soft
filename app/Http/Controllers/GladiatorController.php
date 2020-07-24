<?php

namespace App\Http\Controllers;


use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Gladiator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Image;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Table;


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

        foreach ($gladiators as $gladiator) {
            $k = 1.1;
            $gladiator->thePossibilityOfDeath = 20 / ($gladiator->strength + $gladiator->agility + $gladiator->heals) * $k;
        }

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

        foreach ($gladiators as $gladiator) {
            $k = 1.1;
            $gladiator->thePossibilityOfDeath = 20 / ($gladiator->strength + $gladiator->agility + $gladiator->heals) * $k;
        }

        return View::make('gladiators', ['gladiators' => $gladiators]);

    }

    public function store(Request $request)
    {
//        Создание Гладиаторов
//        $serverName = $_SERVER["HTTP_HOST"];

        $request->validate([
            'name' => 'string',
            'strength' => 'numeric|between:1,10',
            'agility' => 'numeric|between:1,10',
            'heals' => 'numeric|between:1,10',
            'image' => 'image'
        ]);

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

        $k = 1.1;
        $gladiator['thePossibilityOfDeath'] = 20 / ($gladiator['strength'] + $gladiator['agility'] + $gladiator['heals']) * $k;


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

        if($gladiator->seller === $gladiator->master && $gladiator->master !== null) {
            $data['master'] = $idSession;
            $data['seller'] = null;
            Gladiator::getGladiator($id)->update($data);

            return redirect()->route('gladiator.show', [$gladiator->id]);
        }

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

            return redirect()->route('gladiator.show', [$gladiator->id]);
        }
        return redirect()->route('gladiator.show', [$gladiator->id]);

    }


    public function sell($id)
    {

        $user = User::currentUser();

        $data['seller'] = $user->id;

        Gladiator::getGladiator($id)->update($data);

        return redirect()->route('gladiator.index');
    }

public function arenaView() {


    $gladiators = DB::table('gladiators')
        ->where([['arena', '!=', '[NULL]'], ['arena', '!=', '-1']])
        ->get();

    $users = User::all();
        return view('arena', compact(['gladiators', 'users']));

}
    public function arena() {
        $id = $_POST["id"];
        if($_POST['arena'] !== "") {
            $data['arena'] = rand(1,10);
        }
        else {
            $data['arena'] = null;
        }

        DB::table('gladiators')->where('id', $id)->update($data);

        $gladiators = DB::table('gladiators')
            ->where([['arena', '!=', '[NULL]'], ['arena', '!=', '-1']])
            ->get();


        if(count($gladiators) === 4) {
//            каждому начислить бабки (20% от стоимости например) за участие в соответствии с характеристиками

                foreach ($gladiators as $key => $value) {
                    $user = User::getUser($value->master)->first();
                    $dataUser['money'] =$user->money + $value->cost * 0.2;
                    $dataArena['arena'] = null;

                    DB::table('users')
                        ->where('id', $value->master)
                        ->update($dataUser);

                    //            Случайно отсортировать бойцов


                   $gladiatorsList = DB::table('gladiators')
                       ->where('arena', '!=', '[NULL]')
                       ->orderByDesc('arena')
                       ->get();

                    //            выявить соотношение сил, шансы на победу

                    $winner1 = Gladiator::ArenaFight($gladiatorsList[0], $gladiatorsList[1]);
                    $winner2 = Gladiator::ArenaFight($gladiatorsList[2], $gladiatorsList[3]);
                    $champion = Gladiator::ArenaFight($winner1, $winner2);
                    $champion->updated_at = Carbon::now();

                    DB::table('arenaInfo')->insert((array) $champion);

                    DB::table('gladiators')
                        ->where('id', $champion->id)
                        ->update($dataArena);

                    $users = User::all();

                    $lastArenaGladiators = DB::table('arenaInfo')
                        ->orderByDesc('updated_at')
                        ->limit(4)
                        ->get();

                    return redirect()->route('lastArena', compact(['lastArenaGladiators', 'users']));

//                    return view('lastArena', compact(['lastArenaGladiators', 'users']));


//
//                    if(rand(0, ($gladiatorsList[0]->cost + $gladiatorsList[1]->cost)) > $gladiatorsList[0]->cost) {
//                        $user = User::getUser($gladiatorsList[0]->master)->first();
//
//                        $dataUser['money'] =$user->money + 3;
//                        DB::table('users')
//                            ->where('id', $gladiatorsList[0]->master)
//                            ->update($dataUser);
//                        DB::table('gladiators')
//                            ->where('id', $gladiatorsList[1]->id)
//                            ->update($dataArena);
//                    }
//                    else {
//                        $user = User::getUser($gladiatorsList[1]->master)->first();
//
//                        $dataUser['money'] =$user->money + 3;
//                        DB::table('users')
//                            ->where('id', $gladiatorsList[1]->master)
//                            ->update($dataUser);
//                        DB::table('gladiators')
//                            ->where('id', $gladiatorsList[0]->id)
//                            ->update($dataArena);
//                    }


                }

//            рандомно начислить победу в соответствии с шансами, начислить бабки за победу
//            Убить или не убить проигравшего, снять с арены
//            схватка победителей, начислить бабки за победу
//            убить или не убить проигравшего(мб -1 в бд арены), снять с арены
//            незабыть отображение мертвых потом (кладбище может)
//            незабыть отображение арены у пользователей
//            накинуть отображение аренки js'ом
        }

        return redirect()->route('myGladiators');

    }

    public function lastArena() {

        $users = User::all();

        $lastArenaGladiators = DB::table('arenaInfo')
            ->orderByDesc('updated_at')
            ->limit(4)
            ->get();

        return view('lastArena', compact(['lastArenaGladiators', 'users']));
    }

}






