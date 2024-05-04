<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Models\Api\Order;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', false);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Order::query();
        $query->orderBy($sortField, $sortDirection);
        if ($search){
            $query->where('id', 'like', "%{$search}%");
        }
        return OrderListResource::collection($query->paginate($perPage));
    }

    public function view(Order $order)
    {
        return new OrderResource($order);
    }

    public function getStatuses(){
        return OrderStatus::getStatuses();
    }

    public function changeStatus(Order $order, $status){
        $order->status = $status;
        $order->save();
        return response('', 200);
    }
}
