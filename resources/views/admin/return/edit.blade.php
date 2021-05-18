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
            <a href="{{ route('admin.batch.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Inventory&nbsp;
                </p>
            </a>
            /&nbsp;
            <p class="text-blue-500 hover:text-blue-700 font-bold">
                Edit&nbsp;
            </p>
            /&nbsp;
            <p class="text-indigo-700">
                Batch - {{ $batch->batch_no }}
            </p>
        </h1>
        {{-- CONTENT --}}
        <form
            action="{{ route('admin.batch.update', ['batch' => $batch->id]) }}"
            method="post">
            @csrf
            @method('put')
            <div class="flex flex-wrap -mx-1 overflow-hidden">

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto">Product:</label>
                        <h3 class="text-xl p-auto m-auto">{{ $batch->product->id }} - {{ $batch->product->name }}</h3>
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="batch_no">Batch #:</label>
                        <input id="batch_no" name="batch_no" type="text" placeholder="Batch no.." value="{{{ $batch->batch_no }}}">
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="unit_cost">Unit Cost:</label>
                        <input id="unit_cost" name="unit_cost" type="text" placeholder="Unit cost.." value="{{ $batch->unit_cost }}">
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="i_quantity">Initial Quantity:</label>
                        <input id="i_quantity" name="i_quantity" type="text" placeholder="Initial Quantity.." value="{{ $batch->initial_quantity }}">
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="quantity">Remaining Quantity:</label>
                        <input id="r_quantity" name="r_quantity" type="text" placeholder="Remaining Quantity.." value="{{ $batch->remaining_quantity }}">
                    </div>
                </div>
                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="expiration">Expiration:</label>
                        <input id="expiration" name="expiration" type="date" min="{{ date("Y-m-d") }}" value="{{ $batch->expiration }}">
                    </div>
                </div>

                <div class="my-1 px-1 w-1/2 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                        <label class="text-3xl p-auto m-auto" for="expiration">Save Changes</label>
                        <button type="submit" class="m-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>

            </div>
        </form>

        <div class="my-1 px-1 w-1/2 overflow-hidden">
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                <label class="text-3xl p-auto m-auto" for="expiration">Batch Status: {{ $batch->is_active ? 'Active' : 'Disabled' }}</label>
                @if ($batch->is_active == 1)
                <form
                    action="{{ route('admin.batch.destroy', ['batch' => $batch->id]) }}"
                    method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="m-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Disable
                    </button>
                </form>
                @else
                <form
                    action="{{ route('admin.batch.activate', ['id' => $batch->id]) }}"
                    method="post">
                    @csrf
                    <button type="submit" class="m-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Enable
                    </button>
                </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
