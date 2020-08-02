<?php

namespace App;

use App\Exceptions\CustomException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

//    public $money, $rate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'money', 'rate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function currentUser() {
        $value = Session::all();
        $idSession = $value['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'];
        return $user = DB::table('users')
            ->where('id', $idSession)
            ->first();
    }

    public static function getUser($id) {
        return DB::table('users')
            ->where('id', $id);

    }

    public static function checkMoney($attribute) {

       $user = self::currentUser();

       if ($user->money >= $attribute) {
           return $user;
       }

       return null;

    }


    public static function updateAttributes($data, $attribute, $attributeCost, $entityAttribute, $user)
    {
//        try {
            if ($attribute != 0 && !is_null(User::checkMoney($attributeCost))) {

                    $data = $attribute + $entityAttribute;


                $user->money = $user->money - $attributeCost;
                $user = (array)$user;

                User::getUser($user['id'])->update($user);
                return $data;

            } else if ($attribute == 0) {
                $data = $entityAttribute;

                return $data;
            } else {

                throw new CustomException('Недостаточно денег для совершения операции');

            }
//        }
//        catch (CustomException $exception) {
//
//            return view('errors.money', compact('exception'));
//        }
    }

}
