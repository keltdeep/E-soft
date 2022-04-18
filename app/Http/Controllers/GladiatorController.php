<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Gladiator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use JD\Cloudder\Facades\Cloudder;

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

            $gladiator['costStrength'] = $gladiator['cost'] / 10 * 0.5;
            $gladiator['costAgility'] = $gladiator['cost'] / 10 * 0.3;
            $gladiator['costHeals'] = $gladiator['cost'] / 10 * 0.2;

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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|unique:gladiators',
            'strength' => 'numeric|between:1,10',
            'agility' => 'numeric|between:1,10',
            'heals' => 'numeric|between:1,10',
            'image' => 'image'
        ]);

        $gladiator['name'] = filter_var($_POST['name']);
        $gladiator['strength'] = filter_var($_POST['strength'], FILTER_VALIDATE_INT);
        $gladiator['agility'] = filter_var($_POST['agility'], FILTER_VALIDATE_INT);
        $gladiator['heals'] = filter_var($_POST['heals'], FILTER_VALIDATE_INT);

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
            Cloudder::upload($request->file('image'));
            $cloundary_upload = Cloudder::getResult();
            $gladiator["image"] = $cloundary_upload['url'];
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
        $gladiator = Gladiator::query()->findOrFail($id);
        $user = User::currentUser();

        return view('gladiatorView', compact(['gladiator', 'user']));
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
        $dataCost = 0;
        $user = User::currentUser();

        try {
            if ($_POST['strength'] + $gladiator->strength > 10
                || $_POST['agility'] + $gladiator->agility > 10
                || $_POST['heals'] + $gladiator->heals > 10) {

                throw new CustomException('Атрибуты не могут быть больше 10');

            } else {
                if ($_POST['strength']) {
                    $dataCost = $dataCost + $_POST['costStrength'];
                }

                if ($_POST['agility']) {
                    $dataCost = $dataCost + $_POST['costAgility'];
                }

                if ($_POST['heals']) {
                    $dataCost = $dataCost + $_POST['costHeals'];
                }

                if (User::checkMoney($dataCost) === false) {
                    throw new CustomException('Недостаточно денег для совершения операции');
                }
            }
        } catch (CustomException $exception) {
            return view('errors.money', compact('exception'));
        }

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

        try {
            if ($user->money >= $gladiator->cost) {

                $data['master'] = $idSession;

                Gladiator::getGladiator($id)->update($data);

                $dataChange['money'] = $user->money - $gladiator->cost;

                User::getUser($idSession)->update($dataChange);
            } else {
                throw new CustomException('Недостаточно денег для совершения операции');
            }
        } catch (CustomException $exception) {
            return view('errors.money', compact('exception'));
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

        if ($_POST['arena'] !== "") {
            $data['arena'] = rand(1,10);
        } else {
            $data['arena'] = null;
        }

        DB::table('gladiators')->where('id', $id)->update($data);

        $gladiators = DB::table('gladiators')
            ->where([['arena', '!=', '[NULL]'], ['arena', '!=', '-1']])
            ->get();

        if (count($gladiators) === 4) {
            foreach ($gladiators as $key => $value) {
                $user = User::getUser($value->master)->first();
                $dataUser['money'] = $user->money + $value->cost * 0.2;

                DB::table('users')
                    ->where('id', $value->master)
                    ->update($dataUser);
            }

            foreach ($gladiators as $key => $value) {
               $dataArena['arena'] = null;

               $gladiatorsList = DB::table('gladiators')
                   ->where([['arena', '!=', '[NULL]'], ['arena', '!=', -1]])
                   ->orderByDesc('arena')
                   ->get();

               $winner1 = Gladiator::ArenaFight($gladiatorsList[0], $gladiatorsList[1]);
               sleep(1);
               $winner2 = Gladiator::ArenaFight($gladiatorsList[2], $gladiatorsList[3]);
               sleep(1);
               $champion = Gladiator::ArenaFight($winner1, $winner2);
               sleep(1);
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
            }
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

    public function cemeteryView () {
        $users = User::all();

        $deadGladiators = DB::table('arenaInfo')
            ->where('arena', '=', -1)
            ->orderByDesc('updated_at')
            ->simplePaginate(6);

        return view('cemeteryView', compact(['deadGladiators', 'users']));
    }
}






