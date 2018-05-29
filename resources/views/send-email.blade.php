
<html>
<body>
<title>{{__('Shop')}}</title>
<div>
    <h4>{{__('Email')}}: {{$order['email']}}</h4>
</div>
<div>
    <h4>{{__('Comment')}}:{{$order['comments']}}</h4>
</div>
<div>
    @foreach ($order['cart'] as $product)
        <table style="width: 70%; border: solid 1px;">
            <tr>
                <td><img style="width: 100px; height: 100px;" src="{{Storage::disk('public')->url('images/' . $product->image)}}"></td>
                <td>{{$product->title}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}$</td>
            </tr>
        </table>
    @endforeach
</div>
</body>
</html>



