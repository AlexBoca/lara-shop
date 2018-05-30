@extends('app')
@section('content')
    <div style="margin: 5% 35% 5% 35%">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        @isset($product)
            @php($action = route('products.update', $product->id))
        @else
            @php($action = route('products.store'))
        @endisset
        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div style="margin: 5px;">
                <input type="text" name="title" placeholder="{{__('Title')}}"
                       value="{{old('title', $product->title ?? '')}}"/>
            </div>
            <div style="margin: 5px;">
                <textarea name="description"
                          placeholder="{{__('Description')}}">{{old('description', $product->description ?? '')}}</textarea>
            </div>
            <div style="margin: 5px;">
                <input type="text" name="price" placeholder="{{__('Price')}}"
                       value="{{old('price', $product->price ?? '')}}"/>
            </div>
            @isset($product->image)
                <div>
                    <img style="width: 80px; height: 80px;" src="{{Storage::disk('public')->url( $product->image)}} "/>
                </div>
            @endisset
            <div style="margin: 5px;">
                <input type="hidden" name="size" value="1000000"/>
                <input type="file" name="image" id="image"/>
            </div>
            <button name="submit" type="submit">{{__('Save')}}</button>
        </form>
        <a href="{{route('products.index')}}">{{__('Products')}}</a>
    </div>
@endsection


