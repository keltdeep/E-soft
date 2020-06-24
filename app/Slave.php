<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slave extends Model
{

    protected $table = 'slaves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'agility', 'intelligence', 'cost', 'rateComfort', 'dailyExpenses', 'image', 'master'
    ];
//    public $name, $agility, $intelligence, $comfortRate, $cost, $master;
//    public function __construct($name, $agility, $intelligence, $comfortRate, $cost)
//    {
//        $this->name = $name;
//        $this->intelligence = $intelligence;
//        $this->agility = $agility;
//        $this->comfortRate = $comfortRate;
//        $this->cost = $cost;
//
//    }
}
