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
        if ($_POST['email'] === 'keltdeep2@yandex.ru') {
            $currentUser = User::currentUser();
            $userLogin = $currentUser->email;
            $userMessage = $_POST['message'];

            return $this->from(env('MAILGUN_SMTP_LOGIN'))
                ->view('techMessage', compact(['userLogin', 'userMessage']));
        }

        $currentUser = User::currentUser()->name;
        $login = $_POST['email'];
        $name = explode('@', $login);
        $password = Order::generatePassword();
        $server = $_SERVER["HTTP_HOST"];

        $data['email'] = $login;
        $data['name'] = $name['0'];
        $data['password'] = $password;

        RegisterController::create($data);

        return $this->from(env('MAILGUN_SMTP_LOGIN'))
            ->view('inviteMassage', compact(['currentUser', 'login', 'password', 'server']));
    }
}
