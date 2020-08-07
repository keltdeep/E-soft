<?php

namespace App\Mail;



use App\Http\Controllers\Auth\RegisterController;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Экземпляр заказа.
     *
     * @var Order
     */
    public $order;

    /**
     * Создание нового экземпляра сообщения.
     *
     * @param $order
     */


    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//        $request->validate([
//            'email' => 'unique:users,email|nullable',
//        ]);
if ($_POST['email'] === 'keltdeep2@yandex.ru') {
    $currentUser = User::currentUser();
    $login = $currentUser->email;
    $message = $_POST['message'];

    return $this->from(env('MAILGUN_SMTP_LOGIN'))
        ->view('techMessage', compact(['message', 'login']));
    }
        $currentUser = User::currentUser()->name;
        $login = $_POST['email'];
        $name = explode('@', $login);
        $password = Order::generatePassword();

        $data['email'] = $login;
        $data['name'] = $name['0'];
        $data['password'] = $password;

        RegisterController::create($data);

        return $this->from(env('MAILGUN_SMTP_LOGIN'))
            ->view('inviteMassage', compact(['currentUser', 'login', 'password']));

    }
}
