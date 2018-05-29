@php
    if ($_SESSION['cart']) {
        $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
        $query = "SELECT * FROM  products WHERE id IN ($placeholders)";
        $cartList = conn($query, $_SESSION['cart'], true);
    }

    $to = MANAGER_EMAIL;
    $subject = "Shop";

    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type:text/html;charset=UTF-8";
    $headers[] = 'From: <' . filter_var($_POST['email']) . '>';
@endphp
<html>
<body>
<title>{{__('Shop')}}</title>
<div>
    <h4>{{__('Email')}}: {{$_POST['email']}}</h4>
</div>
<div>
    <h4>{{__('Comment')}}:{{$_POST['comments']}}</h4>
</div>
<div>
    @foreach ($cartList as $product)
        <table style="width: 70%; border: solid 1px;">
            <tr>
                <td><img style="width: 100px; height: 100px;" src="{{asset('storage/images/' . $product->image)}}"></td>
                <td>{{$product->title}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}$</td>
            </tr>
        </table>
    @endforeach
</div>
</body>
</html>



