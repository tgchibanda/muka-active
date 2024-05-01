<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $orders =Order::query()->where(['created_by' => $user->id])->paginate(5);

        return view('order.index', compact('orders'));
    }
}
