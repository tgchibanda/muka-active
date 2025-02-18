<h1 style="text-align: center; color: #333;">
    A New Order Has Been Created
</h1>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr style="background-color: #f8f8f8;">
        <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Order ID</th>
        <td style="padding: 10px; border: 1px solid #ddd;">
            <a href="{{ $forAdmin ? 'https://admin.mtisabeehiveproducts.com.au/app/orders/'.$order->id : route('order.view', $order, true) }}" 
               style="color: #007bff; text-decoration: none;">
                #{{ $order->id }}
            </a>
        </td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Order Status</th>
        <td style="padding: 10px; border: 1px solid #ddd;">{{ $order->status }}</td>
    </tr>
    <tr style="background-color: #f8f8f8;">
        <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Shipping Price</th>
        <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($order->shipping_price, 2) }}</td>
    </tr>
    <tr style="background-color: #f8f8f8;">
        <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Order Total</th>
        <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($order->grand_total, 2) }}</td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Order Date</th>
        <td style="padding: 10px; border: 1px solid #ddd;">{{ $order->created_at->format('F j, Y, g:i A') }}</td>
    </tr>
</table>

<h2 style="text-align: center; color: #333;">Order Items</h2>

<table style="width: 100%; border-collapse: collapse;">
    <tr style="background-color: #333; color: #fff;">
        <th style="padding: 10px; text-align: left;">Image</th>
        <th style="padding: 10px; text-align: left;">Title</th>
        <th style="padding: 10px; text-align: left;">Price</th>
        <th style="padding: 10px; text-align: left;">Quantity</th>
    </tr>
    @foreach($order->items as $item)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 10px;">
                <img src="{{ $item->product->image }}" style="width: 80px; height: auto; border-radius: 5px;">
            </td>
            <td style="padding: 10px;">{{ $item->product->title }}</td>
            <td style="padding: 10px;">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
            <td style="padding: 10px;">{{ $item->quantity }}</td>
        </tr>
    @endforeach
</table>
