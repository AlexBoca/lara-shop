@extends('app')
@section('content')
    <div id="content" style="margin: 5% 35% 5% 35%;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        @if(session('user_login'))
            <p>{{'You are logged in!'}}</p>
            <a href="<?= route('logout') ?>"><?= __('Logout') ?></a>
        @else
            <form method="post" action="{{route('login.user')}}">
                {{csrf_field()}}
                <div style="margin: 5px;">
                    <label>{{__('Username')}}</label>
                    <input type="text" name="username" value=""/>
                </div>
                <div style="margin: 5px;">
                    <label>{{__('Password')}}</label>
                    <input type="password" name="password" value=""/>
                </div>
                <button type="submit">{{__('Login')}}</button>
            </form>
        @endif
    </div>
@endsection



