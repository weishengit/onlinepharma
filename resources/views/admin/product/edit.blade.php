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
            <p class="text-indigo-700">
                Edit : {{ $product->name }}
            </p>
            
		</h1>
        
        {{-- START --}}
        <div class="mt-5 md:mt-0 md:col-span-2">
            {{-- FORM --}}
            <form 
                action="{{ route('admin.product.update', ['product' => $product->id]) }}" 
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        {{-- PRODUCT NAME --}}
                        <div class="m-auto">
                            <label for="company_website" class="block text-sm font-medium text-gray-700">
                                Product Name <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                Name
                                </span>
                            <input value="{{ $product->name }}" type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="product name...">
                            </div>
                        </div>
                        {{-- Category --}}
                        <div class="m-auto">
                            <label for="company_website" class="block text-sm font-medium text-gray-700">
                                Category
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    Category
                                </span>
                            <select name="category" id="category" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                <option value="" disabled hidden>Choose category</option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        {{-- CHECK FOR THE PRODUCT CATEGORY --}}
                                        @if ($category->id == $product->category_id)
                                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                        {{-- Generic Name --}}
                        <div class="m-auto">
                            <label for="generic_name" class="block text-sm font-medium text-gray-700">
                                Generic Name
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                Generic Name
                                </span>
                            <input value="{{ $product->generic_name }}" type="text" name="generic_name" id="generic_name" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="example: 'paracetamol', 'ibuprofen'">
                            </div>
                        </div>
                        {{-- Drug Class --}}
                        <div class="m-auto">
                            <label for="drug_class" class="block text-sm font-medium text-gray-700">
                                Drug Class
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                Drug Class
                                </span>
                            <input value="{{ $product->drug_class }}" type="text" name="drug_class" id="drug_class" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="example: 'Analgesics (Non-Opioid)', 'Antipyretics' ,'NSAIDs'">
                            </div>
                        </div>
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                            Description <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1">
                            <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="put product description here">{{ $product->description }}</textarea>
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="m-auto">
                            <label for="price" class="block text-sm font-medium text-gray-700">
                                Price <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    &#8369;
                                </span>
                            <input value="{{ $product->price }}" type="text" name="price" id="price" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="example: 5.00, 80.00">
                            </div>
                        </div>
                        {{-- Measurement --}}
                        <div class="m-auto">
                            <label for="measurement" class="block text-sm font-medium text-gray-700">
                                Measurement
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    Measurement
                                </span>
                            <input value="{{ $product->measurement }}" type="text" name="measurement" id="measurement" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="example: 100mg, 20ml, 5g">
                            </div>
                        </div>
                        {{-- Prescription --}}
                        <div class="m-auto">
                            <label for="is_prescription" class="block text-sm font-medium text-gray-700">
                                Prescription <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    Prescription
                                </span>
                            <select name="is_prescription" id="is_prescription" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                @if ($product->is_prescription == 1)
                                    <option value="0">No</option>
                                    <option selected value="1">Yes</option>
                                @else
                                    <option selected value="0">No</option>
                                    <option value="1">Yes</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        {{-- VAT --}}
                        <div class="m-auto">
                            <label for="is_vatable" class="block text-sm font-medium text-gray-700">
                                Vat <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    Vatable
                                </span>
                            <select name="is_vatable" id="is_vatable" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                @if ($product->is_vatable == 1)
                                    <option value="0">No</option>
                                    <option selected value="1">Yes</option>
                                @else
                                    <option selected value="0">No</option>
                                    <option value="1">Yes</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        {{-- Active --}}
                        <div class="m-auto">
                            <label for="is_available" class="block text-sm font-medium text-gray-700">
                                Avaiable For Sale <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    Avaiable
                                </span>
                            <select name="is_available" id="is_available" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                @if ($product->is_available == 1)
                                    <option value="0">No</option>
                                    <option selected value="1">Yes</option>
                                @else
                                    <option selected value="0">No</option>
                                    <option value="1">Yes</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        {{-- Image --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                            Product Photo
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                        <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                        </div>
                                    <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- SUBMIT --}}
                        @if ($product->is_active == 1)
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                                </button>
                            </div>
                        @endif
            </form>     
                        @if ($product->is_active == 1)
                            {{-- DEACTIVATE PRODUCT --}}
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form 
                                    method="POST"
                                    action="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Deactivate
                                    </button>
                                </form>
                            </div>
                        @else
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <form 
                                method="POST"
                                action="{{ route('admin.product.activate', ['product' => $product->id]) }}">
                                @csrf
                                @method('put')
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Activate
                                </button>
                            </form>
                        </div>
                        @endif
                        
                    </div>
                </div>
        </div>
        {{-- FORM END --}}
        {{-- END --}}
    </div>
</div>
@endsection
