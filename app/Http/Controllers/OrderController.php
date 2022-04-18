<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Swift_TransportException;

class OrderController extends Controller
{

    /**
     * Отправить заданный заказ.
     *
     * @param Request $request
     * @return string
     */
    public function ship(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        $comment = 'Приглашение в игру Spartacus';

        try {
            Mail::to($_POST['email'])->send(new OrderShipped($comment));
            echo 'Сообщение отправлено на адрес '. $_POST['email'];
            die();
        } catch (\Exception $exception) {
            return view('errors.custom', compact('exception'));
        }
    }

    public function show() {
        return view('sendInvite');
    }

    public function techView() {
        return view('tech');
    }

    public function tech(Request $request) {
        $request->validate([
            'message' => ['required', 'string']
        ]);

        $comment = $_POST['message'];

        try {
            Mail::to($_POST['email'])->send(new OrderShipped($comment));
            echo 'Сообщение отправлено в тех. поддержку';
            die();
        } catch (\Exception $exception) {
            return view('errors.money', compact('exception'));
        }
    }
}
