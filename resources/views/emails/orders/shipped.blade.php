<x-mail::message>
# Your Order Has Shipped!

Hi {{ $order->user->name }},

Great news! Your order with the number **{{ $order->order_number }}** has been shipped and is on its way to you.

Here are the details of your order:

<x-mail::table>
| Product | Quantity | Price |
| :------------- |:-------------:| --------:|
@foreach ($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} |
@endforeach
| &nbsp; | **Total** | **${{ number_format($order->total_amount, 2) }}** |
</x-mail::table>

You can view your order and track its status by clicking the button below.

<x-mail::button :url="route('account.orders')">
View My Orders
</x-mail::button>

Thanks for shopping with us,<br>
{{ config('app.name') }}
</x-mail::message>
