@extends('layouts.admin')

@section('style')
    {{-- DATATABLES --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <style>

        /*Overrides for Tailwind CSS */

        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568; 			/*text-gray-700*/
            padding-left: 1rem; 		/*pl-4*/
            padding-right: 1rem; 		/*pl-4*/
            padding-top: .5rem; 		/*pl-2*/
            padding-bottom: .5rem; 		/*pl-2*/
            line-height: 1.25; 			/*leading-tight*/
            border-width: 2px; 			/*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7; 		/*border-gray-200*/
            background-color: #edf2f7; 	/*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;	/*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button		{
            font-weight: 700;				/*font-bold*/
            border-radius: .25rem;			/*rounded*/
            border: 1px solid transparent;	/*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current	{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important; /*bg-indigo-500*/
        }

      </style>
@endsection

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
        <div class="m-2 mt-7 float-right">
            <a href="{{ route('admin.product.create') }}">
                <button type="button" class="block py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Product
                </button>
            </a>
        </div>
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
                {{ $title ?? 'Product' }}
            </p>

		</h1>




        @if (isset($products))
        {{-- Table --}}
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
            <table id="data_table" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th>Options</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Available</th>
                        <th>Tax</th>
                        <th>RX</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <a
                            href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Options
                                </button>
                            </a>
                            @if ($product->is_active == 1)
                                @if (!$product->sale()->exists())
                                    <form action="{{ route('admin.sale.create', ['product' => $product->id]) }}">
                                        <button class="bg-green-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            Add Sale
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.sale.show', ['product' => $product->sale->id]) }}">
                                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            View Sale
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.batch.show', ['batch' => $product->id]) }}">
                                    <button type="button" class="bg-blue-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Stocks
                                    </button>
                                </a>
                            @endif
                        </td>
                        <td> <img width="50" height="50" src="{{ asset('images/'. $product->image) }}" alt="image"></td>
                        <td>{{ $product->category->name ?? 'null'}}</td>
                        <td>{{ $product->name ?? null}}</td>
                        <td>{{ $product->price ?? null}}</td>
                        <td>
                            @if ($product->batches()->exists())
                                <?php $stock = 0; ?>
                                @foreach ($product->batches as $batch)
                                    <?php $stock += $batch->remaining_quantity; ?>

                                @endforeach
                                <?php echo $stock; ?>
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            @if ($product->is_available == 1)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if (isset($product->tax->name))
                                {{ ($product->tax->name . ' - ' . $product->tax->rate * 100 . '%')}}
                            @else
                                null
                            @endif
                        </td>
                        <td>
                            @if ($product->is_prescription == 1)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- Table end --}}
        @else
            There are currently no products in the database.
        @endif

    </div>
</div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

			var table = $('#data_table').DataTable( {
					responsive: true
				} )
				.columns.adjust()
				.responsive.recalc();
		} );
    </script>
@endsection
