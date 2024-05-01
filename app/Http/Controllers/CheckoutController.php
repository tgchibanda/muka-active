<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Cart;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;

class CheckoutController extends Controller
{
    
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        list($products, $cartItems) = Cart::getProductsAndCartItems();

        $lineItems = [];
        $totalPrice = 0;
        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' => $product->title,
                      'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $quantity,
                ];
        }


        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
            'customer_creation' => 'always',
          ]);

          $orderData =[
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
          ];

          $order = Order::create($orderData);

          $paymentData =[
            'order_id' => $order->id, // will use the just created id or the orders table
            'amount' => $totalPrice,
            'status' => PaymentStatus::Pending,
            'updated_by' => $user->id,
            'type' => 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $checkout_session->id,
          ]; 

          Payment::create($paymentData);

          return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        try {
            $session_id = $request->get('session_id');
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

            if(!$checkout_session){
                return view('checkout.failure', compact('customer'));
            }

            $payment = Payment::query()->where(['session_id' => $checkout_session->id, 'status' => PaymentStatus::Pending])->first();

            if(!$payment){
                return view('checkout.failure', compact('customer'));
            }

            $payment->status = PaymentStatus::Paid;
            $payment->update();

            $order = $payment->order;
            $order->status = OrderStatus::Paid;
            $order->update();


            $customer = \Stripe\Customer::retrieve($checkout_session->customer);
            
            return view('checkout.success', compact('customer'));

        } catch (\Exception $e){
            //dd("Ine exception ". $e);
            return view('checkout.failure');
        }
    }
    public function failure(Request $request)
    {
        return view('checkout.failure', compact('customer'));
    }
}
