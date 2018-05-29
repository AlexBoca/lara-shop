@extends('app')
@section('content')
    <div style="margin: 5% 35% 5% 35%;">
        <div>
            @foreach ($items  as $product)
                <table style="width: 70%; border: solid 1px;">
                    <tr>
                        <td>
                            <img style="width: 100px; height: 100px;"
                                 src=" {{Storage::disk('public')->url('images/' . $product->image)}}">
                        </td>
                        <td>
                            <h3>{{$product->title}}</h3>
                            <p>{{$product->description}}</p>
                            <p>{{$product->price}}$</p>
                        </td>
                        <td>
                            <a href="{{route('products.edit', $product->id)}}">{{__('Edit')}}</a>
                            <a href="{{route('products.destroy', $product->id)}}">{{__('Delete')}}</a>
                        </td>
                    </tr>
                </table>
            @endforeach
            <div style="margin: 5px;">
                <a name="add" href="{{route('products.create')}}">{{__('Add')}}</a>
                <a name="log-out" href="{{route('logout')}}">{{__('Logout')}}</a>
            </div>
        </div>
    </div>
@endsection