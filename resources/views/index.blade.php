@extends('app')
@section('content')
    <div style="margin: 5% 35% 5% 35%;">
        @if(isset($items))
            @foreach($items as $product)
                <table style="width: 70%; border: solid 1px;">
                    <tr>
                        <td>
                            <img style="width: 100px; height: 100px;"
                                 src="{{Storage::disk('public')->url( $product->image)}}"/>
                        </td>
                        <td>
                            <h3>{{$product->title}}</h3>
                            <p>{{$product->description}}</p>
                            <p>{{$product->price}}$</p>
                        </td>
                        <td>
                            <a href="{{route('cart.store', [$product->id])}}">{{__('Add')}}</a>
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif
        <div style="margin: 5px;">
            <a href="{{route('cart.show')}}">{{__('Go to cart')}}</a>
        </div>
    </div>
@endsection