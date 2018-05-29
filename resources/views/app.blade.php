<!DOCTYPE html>
<html lang="en">
<body>

<header>
    <div>
        <a href="{{route('cart.index')}}">{{__('Home')}}</a>
        <a href="{{route('cart.show')}}">{{ __('Cart')}}</a>
        <a href="{{route('login')}}">{{__('Login')}}</a>
        @if(session('user_login'))
        <a href="{{route('products.create')}}">{{ __('Create')}}</a>
        <a href="{{route('products.index')}}">{{__('Products')}}</a>
        @endif
    </div>
</header>
@yield('content')
</body>
</html>
