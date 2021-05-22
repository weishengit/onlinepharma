@extends('layouts.admin')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

        <!--Console Content-->
        <div class="flex flex-wrap -mx-1 overflow-hidden">
            @if ($new_orders > 0)
            <div class="my-1 px-1 w-1/2 overflow-hidden">
                <div class="p-2 flex flex-col space-y-3">
                    <a href="{{ route('admin.order.show', ['order' => 'new']) }}">
                    <div class="bg-blue-100 p-5 border-l-4 border-blue-500">
                      <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                        <div class="flex-1 leading-tight text-sm text-blue-700">
                            There are new orders.
                        </div>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            @endif
            @if ($pending_orders > 0)
            <div class="my-1 px-1 w-1/2 overflow-hidden">
                <div class="p-2 flex flex-col space-y-3">
                    <a href="{{ route('admin.order.show', ['order' => 'pending']) }}">
                    <div class="bg-blue-100 p-5 border-l-4 border-blue-500">
                      <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                        <div class="flex-1 leading-tight text-sm text-blue-700">
                            There are orders ready to be delivered/picked-up.
                        </div>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            @endif
            @if ($dispatched_orders > 0)
            <div class="my-1 px-1 w-1/2 overflow-hidden">
                <div class="p-2 flex flex-col space-y-3">
                    <a href="{{ route('admin.order.show', ['order' => 'dispatched']) }}">
                    <div class="bg-green-100 p-5 w-full  border-l-4 border-green-500">
                      <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-green-500 h-4 w-4">
                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                        <div class="flex-1 leading-tight text-sm text-green-700">
                            There are orders waiting to be completed.
                        </div>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            @endif
            @if ($expiring_soon != 0)
            <div class="my-1 px-1 w-1/2 overflow-hidden">
                <div class="p-2 flex flex-col space-y-3">
                    <a href="{{ route('admin.inventory.expiring') }}">
                    <div class="bg-yellow-100 p-5 w-full border-l-4 border-yellow-500">
                      <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-yellow-500 h-4 w-4">
                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                        <div class="flex-1 leading-tight text-sm text-yellow-700">
                            Products are expiring soon.
                        </div>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            @endif
            @if ($has_critical == true)
            <div class="my-1 px-1 w-1/2 overflow-hidden">
                <div class="p-2 flex flex-col space-y-3">
                    <a href="{{ route('admin.inventory.critical') }}">
                    <div class="bg-red-100 p-5 w-full border-l-4 border-red-500">
                      <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-red-500 h-4 w-4">
                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                        </svg>
                        <div class="flex-1 leading-tight text-sm text-red-700">
                            Products are in critical level.
                        </div>
                      </div>
                    </div>
                    </a>
                </div>
            </div>
            @endif

          </div>

        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-green-600"><i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Total Revenue</h5>
                            <h3 class="font-bold text-3xl">&#8369; {{ $total_revenue }} <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-pink-600"><i class="fas fa-users fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Total Users</h5>
                            <h3 class="font-bold text-3xl">{{ $totalUsers ?? 'error' }} <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></h3>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <a href="{{ route('admin.user.index') }}">
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">New Users(Week)</h5>
                            <h3 class="font-bold text-3xl">{{ $newUsers ?? 'error' }} <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></h3>
                        </div>
                    </div>
                </div>
                </a>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <a href="{{ route('admin.order.show', ['order' => 'new']) }}">
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-indigo-600"><i class="fas fa-tasks fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">NEW ORDERS</h5>
                            <h3 class="font-bold text-3xl">{{ $new_orders }}</h3>
                        </div>
                    </div>
                </div>
                </a>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <a href="{{ route('admin.order.show', ['order' => 'pending']) }}">
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-red-600"><i class="fas fa-inbox fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">READY FOR PICK-UP / DELIVERY</h5>
                            <h3 class="font-bold text-3xl">{{ $pending_orders }} <span class="text-red-500"><i class="fas fa-caret-up"></i></span></h3>
                        </div>
                    </div>
                </div>
                </a>
                <!--/Metric Card-->
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Metric Card-->
                <a href="{{ route('admin.order.show', ['order' => 'dispatched']) }}">
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-blue-600"><i class="fas fa-check fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">Confirm Completion</h5>
                            <h3 class="font-bold text-3xl">{{ $dispatched_orders }} <span class="text-red-500"><i class="fas fa-caret-up"></i></span></h3>
                        </div>
                    </div>
                </div>
                </a>
                <!--/Metric Card-->
            </div>
        </div>
        <!--/ Console Content-->

    </div>
</div>
<!--/container-->
@endsection

