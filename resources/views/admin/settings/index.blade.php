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
            <a href="{{ route('admin.setting.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Settings&nbsp;
                </p>
            </a>
        </h1>
        {{-- CONTENT --}}
        <div class="flex flex-wrap mx-1 overflow-hidden pt-10">
            {{-- APP NAME --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2 ">
                <label
                    class="text-xl"
                    for="setting_name">Company Name:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_name"
                    name="setting_name"
                    type="text"
                    value="{{ $settings->name }}">
            </div>
            {{-- ADDRESS --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_address">Company Address:</label>
                <input
                    disabled
                    class="w-full"
                    id="setting_address"
                    name="setting_address"
                    type="text"
                    value="{{ $settings->address }}">
            </div>
            {{-- EMAIL --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_email">Company Email:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_email"
                    name="setting_email"
                    type="email"
                    value="{{ $settings->email }}">
            </div>
            {{-- CONTACT --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_contact">Company Contact:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_contact"
                    name="setting_contact"
                    type="text"
                    value="{{ $settings->contact }}">
            </div>
            {{-- CONTACT --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_contact">Company Contact:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_contact"
                    name="setting_contact"
                    type="text"
                    value="{{ $settings->contact }}">
            </div>
            {{-- MINIMUM ORDER --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_minimum">Minimum Order For Delivery:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_minimum"
                    name="setting_minimum"
                    type="text"
                    value="{{ $settings->minimum_order_cost }}">
            </div>
            {{-- DELIVERY FEE --}}
            <div class="my-1 p-3 w-full overflow-hidden border-solid border-2">
                <label
                    class="text-xl"
                    for="setting_delivery_fee">Delivery Fee:</label>
                <input
                    class="w-full"
                    disabled
                    id="setting_delivery_fee"
                    name="setting_delivery_fee"
                    type="text"
                    value="{{ $settings->delivery_fee }}">
            </div>
            <div class="flex justify-center">
                <div>
                    <a href="{{ route('admin.setting.edit') }}">
                        <button type="button"
                            class="m-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit
                        </button>
                    </a>
                </div>
              </div>

        </div>

    </div>
</div>
@endsection
