<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Gladiator extends Model
{
    public $timestamps = true;
    protected $table = 'gladiators';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'strength', 'agility', 'heals', 'cost', 'rate', 'image', 'master', 'created_at', 'updated_at'
    ];


public static function getGladiator($id) {
    return DB::table('gladiators')
        ->where('id', $id);
}

public static function ArenaFight ($gladiator1, $gladiator2)
{

//    $dataArena['arena'] = null;


    if (rand(0, ($gladiator1->cost + $gladiator2->cost)) > $gladiator2->cost) {


//        вероятность смерти после поражение 70%
        if(rand(1, 10) <= 7) {
            $dataArena['arena'] = -1;
        }
        else {
            $dataArena['arena'] = null;
    }
        $user = User::getUser($gladiator1->master)->first();

        $dataUser['money'] = $user->money + 3;

        $gladiator2->updated_at = Carbon::now();

        DB::table('users')
            ->where('id', $gladiator1->master)
            ->update($dataUser);
        DB::table('gladiators')
            ->where('id', $gladiator2->id)
            ->update($dataArena);

        $gladiator2->arena = $dataArena['arena'];

        DB::table('arenaInfo')->insert((array) $gladiator2);


        return $gladiator1;
    }

    else {

        if(rand(1, 10) <= 7) {
            $dataArena['arena'] = -1;
        }

        else {
            $dataArena['arena'] = null;
        }
        $user = User::getUser($gladiator2->master)->first();

            $dataUser['money'] = $user->money + 3;
            DB::table('users')
                ->where('id', $gladiator2->master)
                ->update($dataUser);
            DB::table('gladiators')
                ->where('id', $gladiator1->id)
                ->update($dataArena);
        $gladiator1->updated_at = Carbon::now();

        $gladiator1->arena = $dataArena['arena'];


        DB::table('arenaInfo')->insert((array) $gladiator1);

        return $gladiator2;

    }
    }


}
