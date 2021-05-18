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
            <a href="{{ route('admin.order.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Order&nbsp;
                </p>
            </a>
            /&nbsp;
            <a href="{{ route('admin.return.index') }}">
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    Returns&nbsp;
                </p>
            </a>
            /&nbsp;
                <p class="text-blue-500 hover:text-blue-700 font-bold">
                    #{{ $return->order->ref_no }}&nbsp;
                </p>
        </h1>
        {{-- CONTENT --}}
        <div class="flex flex-wrap overflow-hidden">
            {{-- COL 1 --}}
            <div class="w-1/2 overflow-hidden">
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Return ID
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->id }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Return Reason
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->reason }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Return Action
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->action }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Return Date
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->created_at }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Reference Number
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->ref_no }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Customer
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->customer }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->address }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Contact
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->contact }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Senior ID
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->scid }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Cashier
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->cashier }}
                    </dd>
                </div>
            </div>
            {{-- COL 2 --}}
            <div class="w-1/2 overflow-hidden">
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Order Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->status }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Message
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->message }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Delivery Mode
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->delivery_mode }} - {{ $return->order->delivery_fee ?? '' }}
                    </dd>
                </div>
                {{-- IS SC --}}
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Senior/PWD
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if ($return->order->is_sc)
                            Yes
                        @else
                            No
                        @endif
                    </dd>
                </div>
                {{-- SC DISCOUNT --}}
                @if ($return->order->is_sc)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Senior/PWD Discount
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->sc_discount }}
                    </dd>
                </div>
                @endif
                {{-- OTHER DISCOUNT --}}
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Other Discount
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if ($return->order->other_discount)
                            {{ $return->order->other_discount }}
                        @else
                            None
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Other Discount Amount
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $return->order->other_discount_rate }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border">
                    <dt class="text-xl font-medium text-gray-500">
                        Total
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        &#8369;{{ $return->order->amount_due }}
                    </dd>
                </div>
            </div>
            {{-- IMAGES --}}
            <div class="flex flex-wrap -mx-1 overflow-hidden text-center">
                {{-- SC PHOTO --}}
                <div class="my-1 px-1 w-1/2 overflow-hidden border">
                    @if ($return->order->is_sc != 0)
                    <div>
                        <h2 class="text-blue-900 text-3xl">SC/PWD ID Photo</h2>
                        <img src="{{ asset('images/temp/sc/' . $return->order->scid_image) }}" alt="scid image">
                    </div>
                    <a
                        href="{{ asset('images/temp/sc/' . $return->order->scid_image) }}"
                        class="">
                        <button type="button"
                            class="m-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View
                        </button>
                    </a>
                    @endif
                </div>
                {{-- RX PHOTO --}}
                <div class="my-1 px-1 w-1/2 overflow-hidden border">
                    @if ($return->order->prescription_image != null)
                    <div>
                        <h2 class="text-gray-900 text-3xl">Prescription Photo</h2>
                        <img src="{{ asset('images/temp/rx/' . $return->order->prescription_image) }}" alt="rx image">
                    </div>
                    <a
                        href="{{ asset('images/temp/rx/' . $return->order->prescription_image) }}"
                        class="">
                        <button type="button"
                            class="m-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View
                        </button>
                    </a>
                    @endif
                </div>
            </div>
        </div>
            {{-- Table --}}
            <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
                <div>
                    <h1 class="font-bold text-3xl">Items</h1>
                </div>
                <table id="data_table" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RX</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Vat Type</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($return->order->items as $item)
                        <tr>
                            <td>{{ $item->product_id }}</td>
                            <th>
                                @if ($item->is_prescription)
                                    Yes
                                @else
                                    No
                                @endif
                            </th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->total_price }}</td>
                            <td>{{ $item->vat_type }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


    </div>
</div>
@endsection

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
