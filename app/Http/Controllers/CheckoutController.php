<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Cart;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Mail\NewOrderEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ShippingService;

class CheckoutController extends Controller
{

    public function checkout(Request $request, ShippingService $shippingService)
{
    /** @var \App\Models\User $user */
    $user = $request->user();

    $customer = $user->customer;
    $post_code = $customer->shippingPostCode->zipcode;
    if (!$customer->billingAddress || !$customer->shippingAddress) {
        return redirect()->route('profile')->with('error', 'Please provide your address details first.');
    }

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    [$products, $cartItems] = Cart::getProductsAndCartItems();

    $orderItems = [];
    $lineItems = [];
    $totalPrice = 0;
    $totalWeight = 0;

    DB::beginTransaction();

    foreach ($products as $product) {
        $quantity = $cartItems[$product->id]['quantity'];
        if ($product->quantity !== null && $product->quantity < $quantity) {
            $message = match ($product->quantity) {
                0 => 'The product "' . $product->title . '" is out of stock',
                1 => 'There is only one item left for product "' . $product->title,
                default => 'There are only ' . $product->quantity . ' items left for product "' . $product->title,
            };
            return redirect()->back()->with('error', $message);
        }
    }

    foreach ($products as $product) {
        $quantity = $cartItems[$product->id]['quantity'];
        $totalPrice += $product->price * $quantity;
        $totalWeight += ($product->weight * $quantity);
        $lineItems[] = [
            'price_data' => [
                'currency' => 'aud',
                'product_data' => [
                    'name' => $product->title,
                    'images' => $product->image ? [$product->image] : [],
                ],
                'unit_amount' => $product->price * 100,
            ],
            'quantity' => $quantity,
        ];
        $orderItems[] = [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
        ];

        if ($product->quantity !== null) {
            $product->quantity -= $quantity;
            $product->save();
        }
    }

    // Calculate shipping cost
    $shippingCost = $shippingService->calculateShippingCost($post_code, $totalWeight);

    // Add the shipping cost as a line item
    $lineItems[] = [
        'price_data' => [
            'currency' => 'aud',
            'product_data' => [
                'name' => 'Shipping',
            ],
            'unit_amount' => $shippingCost * 100, // Convert to cents
        ],
        'quantity' => 1, // Single shipping charge
    ];

    // Calculate the grand total
    $grandTotal = $totalPrice + $shippingCost;

    $session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'customer_creation' => 'always',
        'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.failure', [], true),
    ]);

    try {
        // Create Order
        $orderData = [
            'total_price' => $totalPrice,
            'weight' => $totalWeight,
            'post_code' => $post_code,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];

        $order = Order::create($orderData);

        // Create Order Items
        foreach ($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }

        // Create Payment
        $paymentData = [
            'order_id' => $order->id,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'amount' => $totalPrice,
            'status' => PaymentStatus::Pending,
            'type' => 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id,
        ];
        Payment::create($paymentData);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
        throw $e;
    }

    DB::commit();
    CartItem::where(['user_id' => $user->id])->delete();

    return redirect($session->url);
}


    public function success(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if (!$session) {
                return view('checkout.failure', ['message' => 'Invalid Session ID']);
            }

            $payment = Payment::query()
                ->where(['session_id' => $session_id])
                ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])
                ->first();
            if (!$payment) {
                throw new NotFoundHttpException();
            }
            if ($payment->status === PaymentStatus::Pending->value) {
                $this->updateOrderAndSession($payment);
            }
            $customer = \Stripe\Customer::retrieve($session->customer);

            return view('checkout.success', compact('customer'));
        } catch (NotFoundHttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            return view('checkout.failure', ['message' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => ""]);
    }

    public function checkoutOrder(Order $order, Request $request)
{
    \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

    $lineItems = [];
    //dd($order);
    // Loop through the order items to create line items for each product
    foreach ($order->items as $item) {
        $lineItems[] = [
            'price_data' => [
                'currency' => 'aud',
                'product_data' => [
                    'name' => $item->product->title,
                    'images' => [$item->product->image] // If you have images, you can add them here
                ],
                'unit_amount' => $item->unit_price * 100, // Stripe expects amounts in cents
            ],
            'quantity' => $item->quantity,
        ];
    }

    // Calculate the shipping cost
    $shippingCost = $order->shipping_cost; // Assuming shipping cost is already set in the order

    // Add the shipping cost as a separate line item
    $lineItems[] = [
        'price_data' => [
            'currency' => 'aud',
            'product_data' => [
                'name' => 'Shipping', // This is the shipping label that will appear in the checkout
            ],
            'unit_amount' => $shippingCost * 100, // Stripe expects amounts in cents
        ],
        'quantity' => 1, // Only one shipping charge
    ];

    // Create the Stripe Checkout session
    $session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.failure', [], true),
        'payment_intent_data' => [
            'metadata' => [
                'order_id' => $order->id,
                'grand_total' => $order->grand_total, // Optionally pass the grand total in metadata
            ],
        ],
    ]);

    // Save session ID for later use (e.g., for payment verification)
    $order->payment->session_id = $session->id;
    $order->payment->save();

    // Redirect to the Stripe Checkout session
    return redirect($session->url);
}


    public function webhook()
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $endpoint_secret = env('WEBHOOK_SECRET_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 401);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 402);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Payment::query()
                    ->where(['session_id' => $sessionId, 'status' => PaymentStatus::Pending])
                    ->first();
                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    private function updateOrderAndSession(Payment $payment)
    {
        DB::beginTransaction();
        try {
            $payment->status = PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order;

            $order->status = OrderStatus::Paid->value;
            $order->update();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. '. $e->getMessage());
            throw $e;
        }

        DB::commit();

        try {
            $adminUsers = User::where('is_admin', 1)->get();

            foreach ([...$adminUsers, $order->user] as $user) {
                Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
            }
        } catch (\Exception $e) {
            Log::critical('Email sending does not work. '. $e->getMessage());
        }
    }
}