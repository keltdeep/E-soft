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

}
