@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach ($products as $product)
            <div class="col-sm-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <a href="{{ route('product.detail', ['id' => $product->id]) }}"><img
                                src="{{ asset('images/') }}/{{ $product->image }}" alt="" class="img-fluid"></a>
                        <div class="card-heading">$ {{ $product->price }} </div>
                        <button style="float:right; background-color: #0abf53; border: none;"
                            class="btn btn-danger btn-xs"><a href="{{ route('product.detail', ['id' => $product->id]) }}"
                                style="color: #fff;">View Item</a></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
