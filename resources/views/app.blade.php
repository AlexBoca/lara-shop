<!DOCTYPE html>
<html lang="en">
<body>

<header>
    <div>
        <a href="{{route('index')}}">{{__('Home')}}</a>
        <a href="{{route('cart')}}">{{ __('Cart')}}</a>
        <a href="{{route('login')}}">{{__('Login')}}</a>
        @if(isset($_SESSION['user_login']))
        <a href="{{route('product.create')}}">{{ __('Create')}}</a>
        <a href="{{route('products')}}">{{__('Products')}}</a>
        @endif
    </div>
</header>
@yield('content')
</body>
</html>
