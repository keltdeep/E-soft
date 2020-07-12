<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    /**
     * Отправить заданный заказ.
     *
     * @return void
     */
    public function ship()
    {


        $comment = 'Приглашение в игру Spartacus';
        $toEmail = $_POST['email'];
        Mail::to($toEmail)->send(new OrderShipped($comment));
        return 'Сообщение отправлено на адрес '. $toEmail;

    }

    public function show() {
        return view('sendInvite');
    }

}
