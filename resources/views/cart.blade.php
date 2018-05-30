@extends('app')
@section('content')
    <div style="margin: 5% 35% 5% 35%;">
        <div>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            @foreach($items as $product)
                <table style="width: 70%; border: solid 1px;">
                    <tr>
                        <td><img style="width: 100px; height: 100px;"
                                 src="{{Storage::disk('public')->url('images/' . $product->image)}}  "/></td>
                        <td>
                            <h3>{{$product->title}}</h3>
                            <p>{{$product->description}}</p>
                            <p>{{$product->price}}$</p>
                        </td>
                        <td>
                            <a href="{{route('cart.delete',$product->id)}}">{{__('Remove')}}</a>
                        </td>
                    </tr>
                </table>
            @endforeach
        </div>
        <div style="margin: 5px;">
            <a name="to-index" href=" {{route('cart.index')}}">{{__('Go to index')}} </a>
            <a name="remove-all" href="{{route('cart.destroy')}}">{{__('Remove all')}}</a>
        </div>
        <form method="post" action="{{route('cart.email')}}">
            {{csrf_field()}}
            <div style="margin: 5px;">
                <input type="text" name="email" placeholder="{{__('Email')}}" value=""/>
            </div>
            <div style="margin: 5px;">
                <textarea name="comments" placeholder="{{__('Comments')}}"></textarea>
            </div>
            <button type="submit">{{__('Checkout')}}</button>
        </form>
    </div>
@endsection


