<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    /**
     * Отправить заданный заказ.
     *
     * @return string
     */
    public function ship()
    {

//        $toEmail = [];
        $comment = 'Приглашение в игру Spartacus';
//        $toEmail['email']= $_POST['email'];

        Mail::to($_POST['email'])->send(new OrderShipped($comment));
        return 'Сообщение отправлено на адрес '. $_POST['email'];

    }

    public function show() {
        return view('sendInvite');
    }

}
