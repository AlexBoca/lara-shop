@extends('app')
@section('content')
    @php
        if (isset($_SESSION['old']['title'])) {

            $title = oldData('title');
        } else {
            $title = isset($product) ? strip_tags($product->title) : '';
        }
        if (isset($_SESSION['old']['description'])) {
            $description = oldData('description');
        } else {
            $description = isset($product) ? strip_tags($product->description) : '';
        }
        if (isset($_SESSION['old']['price'])) {
            $price = oldData('price');
        } else {
            $price = isset($product) ? strip_tags($product->price) : '';
        }
    @endphp
    <div style="margin: 5% 35% 5% 35%">
        @if(isset($_SESSION['errors']) && !empty($_SESSION['errors']))
            @foreach ($_SESSION['errors'] as $name => $value)
                <p>@php(flash($name))</p>
            @endforeach
        @endif
        @if (isset($product))
            @php($action = route('product.update', $product->id))
        @else
            @php($action = route('product.create'))
        @endif

        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div style="margin: 5px;">
                <input type="text" name="title" placeholder="{{__('Title')}}" value="{{$title}}"/>
            </div>
            <div style="margin: 5px;">
                <textarea name="description" placeholder="{{__('Description')}}">{{$description}}</textarea>
            </div>
            <div style="margin: 5px;">
                <input type="text" name="price" placeholder="{{__('Price')}}" value="{{$price}}"/>
            </div>
            @if (isset($product->image))
                <div>
                    <img style="width: 80px; height: 80px;" src="{{  asset('storage/images/' . $product->image)  }} ">
                </div>
                @endif
            <div style="margin: 5px;">
                <input type="hidden" name="size" value="1000000">
                <input type="file" name="image" id="image"
                       value="@php((isset($product) ? strip_tags($product->image) : ''))  "/>
            </div>
            <button name="submit" type="submit">{{__('Save')}}</button>
        </form>
        <a href="{{route('products')}}">{{__('Products')}}</a>
    </div>
@endsection


