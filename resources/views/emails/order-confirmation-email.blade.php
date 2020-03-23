<p>Спасибо за заказ!</p>

<p>Заказ номер {{ $order->id }} завершен</p>

<p>Состав заказа: </p>

@foreach($order->products as $product)
	{{$product->product->name}} <br/>
@endforeach
<p>
	Стоимость {{ $order->sum }}
</p>
