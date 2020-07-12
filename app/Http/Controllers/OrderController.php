<?php

namespace App\Http\Controllers;

use App\Order;
use App\Mail\OrderShipped;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Transport\MailgunTransport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    /**
     * Отправить заданный заказ.
     *
     * @param Order $order
     * @return void
     */
    public function ship()
    {

//        new MailgunTransport('keltdeep@gmail.com', '63d62dba7b96608c2a58c8dcb19ad4ae-87c34c41-3032e843', 'sandboxeb269e13bbaa43468bdcb4858c728316.mailgun.org')

        $comment = 'Приглашение в игру ';
        $toEmail = $_POST['email'];

        Mail::to($toEmail)->send(new OrderShipped($comment));
        return 'Сообщение отправлено на адрес '. $toEmail;


//        $order = User::currentUser();
//        $order = Order::findOrFail($order);
//        var_dump($order);
//        die();
        // Отправить заказ...
//$massage = view('sendInvite');

//        Mail::to($_POST['email'])->send(new OrderShipped($order));
    }

    public function show() {
        return view('sendInvite');
    }

}
