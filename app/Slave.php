<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slave extends Model
{

    protected $table = 'slaves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'agility', 'intelligence', 'cost', 'rateComfort', 'dailyExpenses', 'image', 'master'
    ];
    public static function getSlave($id)
    {
        return DB::table('slaves')
            ->where('id', $id);
    }
}
