<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    public static $order;

    public static function findOrFail($orderId)
    {

        return $order = DB::table('users', $orderId)->first();
    }
    public static function generatePassword ($length = 8)
    {
        $password = "";

        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

        $maxlength = strlen($possible);

        if ($length > $maxlength) {
            $length = $maxlength;
        }

        $i = 0;

        while ($i < $length) {
            $char = substr($possible, mt_rand(0, $maxlength-1), 1);
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }

        return $password;
    }
}
