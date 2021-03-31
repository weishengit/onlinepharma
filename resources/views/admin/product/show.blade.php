@extends('layouts.admin')


@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        {{-- PAGE START --}}

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
            <div class="w-4/5 m-auto mt-10 pl-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Title --}}
        <h1 class="border-2 flex items-center font-sans font-bold break-normal text-gray-900 px-2 py-8 text-lg md:text-2xl">
			<a 
                href="{{ route('admin.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Dashboard&nbsp;
                </p>
                
            </a>
            /&nbsp;
            <a 
                href="{{ route('admin.product.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Products&nbsp;
                </p>
                
            </a>
            /&nbsp;
            <p class="text-blue-500">
                Show&nbsp;
            </p>
            :&nbsp;
            <p class="text-indigo-700">
                {{ $product->name }}
            </p>
		</h1>
        {{-- CONTENT --}}
        <div>
            {{-- BORDER --}}
            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                <div class="border-t border-gray-200"></div>
                </div>
            </div>
            {{-- FIELD CONTAINER --}}
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-2 md:gap-6">
                    {{-- TITLE --}}
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-3xl font-medium leading-6 text-gray-900">Product Information</h3>  
                        </div>
                    </div>
                    {{-- FIELD GROUP --}}
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-8 gap-6">
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input disabled value="{{ $product->name ?? ''}}" type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="generic_name" class="block text-sm font-medium text-gray-700">Generic Name</label>
                                        <input disabled value="{{ $product->generic_name ?? ''}}" type="text" name="generic_name" id="generic_name"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="drug_class" class="block text-sm font-medium text-gray-700">Drug Class</label>
                                        <input disabled value="{{ $product->drug_class ?? ''}}" type="text" name="drug_class" id="drug_class" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                        <input disabled value="{{ $product->category->name ?? ''}}" type="text" name="category" id="category" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input disabled value="&#8369; {{ $product->price ?? ''}}" type="text" name="price" id="price   " class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                        <input disabled value="{{ $product->stock ?? ''}}" type="text" name="stock" id="stock" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="measurement" class="block text-sm font-medium text-gray-700">Measurement</label>
                                        <input disabled value="{{ $product->measurement ?? ''}}" type="text" name="measurement" id="measurement" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="prescription" class="block text-sm font-medium text-gray-700">Prescription</label>
                                        <input 
                                            disabled 
                                            type="text" 
                                            name="prescription"
                                            id="prescription" 
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            @if ($product->is_prescription == 1)
                                                value="Yes"
                                            @else
                                                value="No"
                                            @endif >
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="available" class="block text-sm font-medium text-gray-700">Available</label>
                                        <input 
                                            disabled 
                                            type="text" 
                                            name="available"
                                            id="available" 
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            @if ($product->is_available == 1)
                                                value="Yes"
                                            @else
                                                value="No"
                                            @endif >
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                        <label for="created" class="block text-sm font-medium text-gray-700">Product Added</label>
                                        <input disabled value="{{ $product->created_at ?? ''}}" type="text" name="created" id="created" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                        <label for="updated" class="block text-sm font-medium text-gray-700">Last Modified</label>
                                        <input disabled value="{{ $product->updated_at ?? ''}}" type="text" name="updated" id="updated" autocomplete="postal-code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    {{-- FIELD ITEM --}}
                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Product Description</label>
                                        <textarea disabled id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            {{ $product->description }}
                                        </textarea>
                                    </div>

                                </div>
                            </div>
                            {{-- BUTTONS --}}
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <div class="">
                                    <div class="m-auto float-right">
                                        <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                                            <button type="button" class="py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Edit
                                            </button>
                                        </a>
                                    </div>
                                    <div class="m-auto mr-3 float-right">
                                        <form 
                                            action="{{ route('admin.product.destroy', ['product' => $product->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-md text-white bg-red-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- FIELD GROUP END--}}
                </div>
            </div>
            {{-- FIELD CONTAINER END --}}
            
        </div>
        {{-- CONTENT END --}}

        {{-- PAGE END --}}
    </div>
</div>
<!-- Container end -->
@endsection
