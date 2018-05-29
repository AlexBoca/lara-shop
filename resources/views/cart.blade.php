@extends('app')
@section('content')
    <div style="margin: 5% 35% 5% 35%;">
        <div>
            @if(isset($_GET['mail']))
                <h4>{{__('Thanks for contacting us.')}}</h4>
            @endif
            @foreach($items as $product)
                <table style="width: 70%; border: solid 1px;">
                    <tr>
                        <td><img style="width: 100px; height: 100px;"
                                 src="{{asset('storage/images/' . $product->image)}}  "></td>
                        <td>
                            <h3>{{$product->title}}</h3>
                            <p>{{$product->description}}</p>
                            <p>{{$product->price}}$</p>
                        </td>
                        <td>
                            <a href="{{route('remove', ['id' => $product->id])}}">{{__('Remove')}}</a>
                        </td>
                    </tr>
                </table>
            @endforeach
        </div>
        <div style="margin: 5px;">
            <a name="to-index" href=" {{route('index')}}">{{__('Go to index')}} </a>
            <a name="remove-all" href="{{route('remove-all')}}">{{__('Remove all')}}</a>
        </div>
        <form method="post" action="{{route('cart')}}" enctype="multipart/form-data">
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


