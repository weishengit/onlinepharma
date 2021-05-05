@extends('layouts.admin')

@section('content')
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        {{-- Message --}}
        @if (session()->has('message'))
        <div class="p-10 flex flex-col space-y-3">
            <div class="bg-blue-100 p-5 w-full sm:w-1/2 border-l-4 border-blue-500">
                <div class="flex space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="flex-none fill-current text-blue-500 h-4 w-4">
                        <path
                            d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                    <div class="flex-1 leading-tight text-sm text-blue-700">{{ session()->get('message') }}</div>
                </div>
            </div>
        </div>
        @endif
        {{-- Error --}}
        @if ($errors->any())
        <div class="m-auto mt-10 pl-2 bg-red-200">
            <h2 class="text-2xl p-4">Please check the following fields</h2>
            <hr>
            <ul>
                @foreach ($errors->all() as $error)
                <li class="p-2">* {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {{-- Title --}}
        <h1 class="border-2 flex items-center font-sans font-bold break-normal text-gray-900 px-2 py-8 text-lg md:text-2xl">
            <a href="{{ route('admin.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Dashboard&nbsp;
                </p>
            </a>
            /&nbsp;
            <a href="{{ route('admin.sale.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Sale&nbsp;
                </p>
            </a>
            /&nbsp;
            <p class="text-blue-500 hover:text-blue-700 font-bold">
                Edit&nbsp;
            </p>
            /&nbsp;
            <p class="text-indigo-700">
                ID #{{ $sale->id }}
            </p>
        </h1>
        {{-- CONTENT --}}
        <form
            action="{{ route('admin.sale.update', ['product' => $sale->id]) }}"
            method="post">
            @csrf
            @method('put')
            <div class="flex items-center justify-center h-screen">

                <img src="{{ asset('images/' . $sale->product->image) }}" alt="product image" si>

            </div>
            <div class="flex flex-wrap -mx-1 overflow-hidden text-2xl">

                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>Product ID: </strong>
                    {{ $sale->product->id }}
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>Discount Rate: </strong>
                    <br>
                    <label for="flat">Flat</label>
                    <input id="flat" type="radio" name="type" value="0" @if ($sale->is_percent == 0) checked @endif>
                    &nbsp;&nbsp;
                    <label for="percent">Percent</label>
                    <input id="percent" type="radio" name="type" value="1" @if ($sale->is_percent == 1) checked @endif>
                    <br>
                    <div class="p-4">
                        <label for="rate">Rate</label>
                        <input id="rate" name="rate" type="text" value="{{ $sale->rate }}" placeholder="Rate...">
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>Product Name: </strong>
                    {{ $sale->product->name }}
                </div>



                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>Price: </strong>
                    &#8369;{{ $sale->product->price }}
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>Actions:   </strong>
                        <br>
                        <button type="submit" class="m-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create
                        </button>
                        </a>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden border p-5">
                    <strong>New Price: </strong>
                    &#8369;
                    @if ($sale->is_percent)
                        {{ round(($sale->product->price - ($sale->product->price * ($sale->rate / 100))),2 )  }}
                    @else
                        {{ $sale->product->price - $sale->rate }}
                    @endif
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
