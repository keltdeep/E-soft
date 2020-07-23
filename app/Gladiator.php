<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Gladiator extends Model
{
    protected $table = 'gladiators';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'strength', 'agility', 'heals', 'cost', 'rate', 'image', 'master'
    ];

public static function getGladiator($id) {
    return DB::table('gladiators')
        ->where('id', $id);
}

public static function ArenaFight ($gladiator1, $gladiator2)
{

    $dataArena['arena'] = null;


    if (rand(0, ($gladiator1->cost + $gladiator2->cost)) > $gladiator1->cost) {
        $user = User::getUser($gladiator1->master)->first();

        $dataUser['money'] = $user->money + 3;

//        вероятность смерти после поражение 70%
        if(rand(1, 10) <= 7) {
            $dataArena['master'] = -1;
        }
        else {
            $dataArena['master'] = $gladiator2->master;
    }


        DB::table('users')
            ->where('id', $gladiator1->master)
            ->update($dataUser);
        DB::table('gladiators')
            ->where('id', $gladiator2->id)
            ->update($dataArena);

        DB::table('arenaInfo')->insert((array) $gladiator2);


        return $gladiator1;
    }

    else {
            $user = User::getUser($gladiator2->master)->first();

        if(rand(1, 10) <= 7) {
            $dataArena['master'] = -1;
        }

        else {
            $dataArena['master'] = $gladiator1->master;
        }

            $dataUser['money'] = $user->money + 3;
            DB::table('users')
                ->where('id', $gladiator2->master)
                ->update($dataUser);
            DB::table('gladiators')
                ->where('id', $gladiator1->id)
                ->update($dataArena);

        DB::table('arenaInfo')->insert((array) $gladiator1);

        return $gladiator2;

    }
    }


}
