<?php

namespace App\Http\Controllers;

use App\Order;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

//class OrderController extends Controller
//{
//    /**
//     * Отправить заданный заказ.
//     *
//     * @param  Request  $request
//     * @param  int  $orderId
//     * @return Response
//     */
//    public function ship(Request $request, $orderId)
//    {
//        $order = Order::findOrFail($orderId);
//
//        // Отправить заказ...
//
//        Mail::to($request->user())->send(new OrderShipped($order));
//}
