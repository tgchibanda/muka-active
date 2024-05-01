<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Cart;

class CheckoutController extends Controller
{
    
    public function checkout(Request $request)
    {
        list($products, $cartItems) = Cart::getProductsAndCartItems();

        $lineItems = [];
        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' => $product->title,
                      'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $cartItems[$product->id]['quantity'],
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

          return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
            if(!$checkout_session){
                return view('checkout.failure', compact('customer'));
            }
            $customer = \Stripe\Customer::retrieve($checkout_session->customer);
            return view('checkout.success', compact('customer'));
        } catch (\Exception $e){
            return view('checkout.failure');
        }
    }
    public function failure(Request $request)
    {
        return view('checkout.failure', compact('customer'));
    }
}
