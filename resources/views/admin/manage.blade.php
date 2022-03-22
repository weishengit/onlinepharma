@extends('layouts.admin')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        {{-- Message --}}
        @if (session()->has('message'))
        <div class="p-10 flex flex-col space-y-3">
            <div class="bg-blue-100 p-5 w-full sm:w-1/2 border-l-4 border-blue-500">
              <div class="flex space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" /></svg>
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
			<a
                href="{{ route('admin.index') }}">
                <p
                    class="text-blue-500 hover:text-blue-700 font-bold">
                    Dashboard&nbsp;
                </p>
            </a>
            /&nbsp;
            <p class="text-indigo-700">
                Management
            </p>
		</h1>

        {{-- Cards --}}
        <div class="flex flex-col">
            {{-- Sales --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <a
                        href="{{ route('admin.sale.index') }}">

                        <div class="max-w-2xl bg-white border-2 border-gray-300 p-5 rounded-md tracking-wide shadow-lg">
                            <div id="header" class="">
                                <h4 id="name" class="text-blue-500 text-2xl font-semibold mb-2">Sales</h4>
                                <p id="job" class="text-gray-800 mt-2 text-sm">Manage Ongoing Sales.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Taxes --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <a
                        href="{{ route('admin.tax.index') }}">

                        <div class="max-w-2xl bg-white border-2 border-gray-300 p-5 rounded-md tracking-wide shadow-lg">
                            <div id="header" class="">
                                <h4 id="name" class="text-blue-500 text-2xl font-semibold mb-2">Taxes</h4>
                                <p id="job" class="text-gray-800 mt-2 text-sm">Manage Taxes.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Categories --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <a
                        href="{{ route('admin.category.index') }}">

                        <div class="max-w-2xl bg-white border-2 border-gray-300 p-5 rounded-md tracking-wide shadow-lg">
                            <div id="header" class="">
                                <h4 id="name" class="text-blue-500 text-2xl font-semibold mb-2">Categories</h4>
                                <p id="job" class="text-gray-800 mt-2 text-sm">Manage Categories.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Discounts --}}
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <a
                        href="{{ route('admin.discount.index') }}">

                        <div class="max-w-2xl bg-white border-2 border-gray-300 p-5 rounded-md tracking-wide shadow-lg">
                            <div id="header" class="">
                                <h4 id="name" class="text-blue-500 text-2xl font-semibold mb-2">Discounts</h4>
                                <p id="job" class="text-gray-800 mt-2 text-sm">Manage Discounts.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        {{-- Cards End --}}
    </div>
</div>
@endsection
