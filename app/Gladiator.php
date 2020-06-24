<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gladiator extends Model
{
    protected $table = 'gladiators';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'strength', 'agility', 'heals', 'cost', 'rate', 'image', 'master'
    ];





}
