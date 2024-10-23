<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Models\Api\Order;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Controller;
use App\Mail\OrderUpdateEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', false);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Order::query()
                    ->withCount('items')
                    ->with('user.customer');
        $query->orderBy($sortField, $sortDirection);
        if ($search){
            $query->where('id', 'like', "%{$search}%");
        }
        return OrderListResource::collection($query->paginate($perPage));
    }

    public function view(Order $order)
    {
        $order->load('items.product');
        return new OrderResource($order);
    }

    public function getStatuses(){
        return OrderStatus::getStatuses();
    }

    public function changeStatus(Order $order, $status)
    {
        DB::beginTransaction();
        try {
            $order->status = $status;
            $order->save();

            if ($status === OrderStatus::Cancelled->value) {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product && $product->quantity !== null) {
                        $product->quantity += $item->quantity;
                        $product->save();
                    }
                }
            }
            Mail::to($order->user)->send(new OrderUpdateEmail($order));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return response('', 200);
    }
}