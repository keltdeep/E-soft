<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Slave;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use JD\Cloudder\Facades\Cloudder;

class SlaveController extends Controller
{
    public function slaveList()
    {
        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];

        $slaves = DB::table('slaves')
            ->where('master', '=', $idSession)
            ->orderBy('name')
            ->simplePaginate(3);

        return View::make('mySlaves', ['slaves' => $slaves]);
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_URI"] === "/slave/$id/edit") {

            $slave = Slave::getSlave($id)->first();

            $slave = (array)$slave;

            $k = 1.8;

            $slave['costAgility'] = $slave['cost'] / 10 * 0.8;
            $slave['costIntelligence'] = $slave['cost'] / 10 * 0.2;
            $slave['comfortRate'] = $slave['cost'] * $k;

            return view('slaveEdit', compact('slave'));
        }

        return null;
    }

    public function create()
    {
        $user = USER::currentUser();

        if ($user->administration === true) {
            return view('createSlave');
        }

        return null;
    }

    public function index()
    {
        $slaves = DB::table('slaves')
            ->where('master', '=', NULL)
            ->orWhereNotNull('seller')
            ->orderBy('name')
            ->simplePaginate(3);

        return View::make('slaves', ['slaves' => $slaves]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|unique:slaves',
            'agility' => 'numeric|between:1,10',
            'intelligence' => 'numeric|between:1,10',
            'image' => 'image'
        ]);

        $k = 1.8;

        $slave['name'] = filter_var($_POST['name']);
        $slave['agility'] = filter_var($_POST['agility'], FILTER_VALIDATE_INT);
        $slave['intelligence'] = filter_var($_POST['intelligence'], FILTER_VALIDATE_INT);
        $slave['cost'] = $slave['agility'] * 0.8 + $slave['intelligence'] * 0.2;
        $slave['rateComfort'] = $slave['cost'] * $k;
        $slave['dailyExpenses'] = $slave['rateComfort'] / 15;

        if (!$_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
            Cloudder::upload($request->file('image'));
            $cloundary_upload = Cloudder::getResult();
            $slave["image"] = $cloundary_upload['url'];;
        }

        DB::table('slaves')
            ->insert($slave);

        $slaveGet = Slave::all();

        $slavesArray = $slaveGet->toArray();

        foreach ($slavesArray as $key => $value) {
            if ($value['name'] == $slave['name']) {
                $id = intval($value['id']);

                view('slaveView', ['slave' => $value]);
                return redirect()->route('slave.show', [$id]);
            }
        }

        return null;
    }

    public function show($id)
    {
        $slave = Slave::query()->findOrFail($id);
        $user = User::currentUser();

        return view('slaveView', compact(['slave', 'user']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'agility' => 'numeric|between:0,1',
            'intelligence' => 'numeric|between:0,1',
        ]);

        if ($_SERVER["REQUEST_URI"] === "/slave/$id/edit") {

            $slave = Slave::getSlave($id)->first();

            $slave = (array)$slave;

            return view('slaveEdit', compact('slave'));
        }

        $slave = Slave::getSlave($id)->first();

        $user = User::currentUser();
        $dataCost = 0;
        $data = array();

        try {
            if ($_POST['agility'] + $slave->agility > 10
                || $_POST['intelligence'] + $slave->intelligence > 10) {

                throw new CustomException('Атрибуты не могут быть больше 10');
            } else {
                if ($_POST['agility'] != 0 ) {
                    $dataCost = $dataCost + $_POST['costAgility'];
                }

                if ($_POST['intelligence'] != 0 ) {
                    $dataCost = $dataCost + $_POST['costIntelligence'];
                }

                if (User::checkMoney($dataCost) === false) {
                    throw new CustomException('Недостаточно денег для совершения операции');
                }
            }
        } catch (CustomException $exception) {
            return view('errors.money', compact('exception'));
        }

        $data['agility'] = User::updateAttributes($data, $_POST['agility'], $_POST['costAgility'], $slave->agility, $user);

        $data['intelligence'] = User::updateAttributes($data, $_POST['intelligence'], $_POST['costIntelligence'], $slave->intelligence, $user);

        $k = 1.8;

        $data['cost'] = ($data['agility'] * 0.8 + $data['intelligence'] * 0.2) * $k;
        $data['rateComfort'] = $data['cost'] * $k;
        $data['dailyExpenses'] = $data['rateComfort'] / 15;

        Slave::getSlave($id)->update($data);

        return redirect()->route('slave.show', [$id]);
    }

    public function buy($id)
    {
        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];

        $user = User::getUser($idSession)->first();
        $slave = Slave::getSlave($id)->first();

        if ($slave->seller === $slave->master && $slave->master !== null) {
            $data['master'] = $idSession;
            $data['seller'] = null;
            Slave::getSlave($id)->update($data);

            return redirect()->route('slave.show', [$slave->id]);
        }

        try {
            if ($user->money >= $slave->cost) {

                $data['master'] = $idSession;

                Slave::getSlave($id)->update($data);

                $dataChange['money'] = $user->money - $slave->cost;

                User::getUser($idSession)->update($dataChange);
            } else {
                throw new CustomException('Недостаточно денег для совершения операции');
            }
        } catch (CustomException $exception) {
            return view('errors.money', compact('exception'));
        }

        if ($slave->seller !== null) {
            $user = User::getUser($slave->seller)->first();

            $changeMoneySeller['money'] = $user->money + $slave->cost;

            User::getUser($slave->seller)->update($changeMoneySeller);

            $changeSlave['seller'] = null;

            Slave::getSlave($id)->update($changeSlave);
        }

        return redirect()->route('slave.show', [$id]);
    }

    public function sell($id)
    {
        $user = User::currentUser();

        $data['seller'] = $user->id;

        Slave::getSlave($id)->update($data);

        return redirect()->route('slave.index');
    }
}
