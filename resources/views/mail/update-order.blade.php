<h2>
    Your order status has been changed to "{{$order->status}}"
</h2>
<p>
    Link to your order:
    <a href="{{route('order.view', $order, true)}}">Order #{{$order->id}}</a>
</p>