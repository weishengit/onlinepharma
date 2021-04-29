@extends('layouts.admin')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

        <!--Console Content-->

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
                            <h3 class="font-bold text-3xl">&#8369; 0 <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
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
                <a href="{{ route('admin.product.index') }}">
                <div class="bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-blue-600"><i class="fas fa-server fa-2x fa-fw fa-inverse"></i></div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-bold uppercase text-gray-500">TOTAL PRODUCTS</h5>
                            <h3 class="font-bold text-3xl">{{ $totalProducts ?? 'error' }}</h3>
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
        </div>

        <!--Divider-->
        <hr class="border-b-2 border-gray-400 my-8 mx-4">

        <div class="flex flex-row flex-wrap flex-grow mt-2">

            {{-- <div class="w-full md:w-1/2 p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Graph</h5>
                    </div>
                    <div class="p-5">
                        <canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
                        <script>
                        new Chart(document.getElementById("chartjs-7"), {
                            "type": "bar",
                            "data": {
                                "labels": ["January", "February", "March", "April"],
                                "datasets": [{
                                    "label": "Page Impressions",
                                    "data": [10, 20, 30, 40],
                                    "borderColor": "rgb(255, 99, 132)",
                                    "backgroundColor": "rgba(255, 99, 132, 0.2)"
                                }, {
                                    "label": "Adsense Clicks",
                                    "data": [5, 15, 10, 30],
                                    "type": "line",
                                    "fill": false,
                                    "borderColor": "rgb(54, 162, 235)"
                                }]
                            },
                            "options": {
                                "scales": {
                                    "yAxes": [{
                                        "ticks": {
                                            "beginAtZero": true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                    </div>
                </div>
                <!--/Graph Card-->
            </div> --}}

            <div class="w-full md:w-full p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">New Users(Current Year)</h5>
                    </div>
                    <div class="p-5">
                        <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                        <script>

                        // AUTOLOAD
                        window.onload = function load_users() {

                            // CREATE XHR
                            var xhr = new XMLHttpRequest();
                            xhr.open("GET", "{{ route('dash_users') }}", true);
                            var userData = [];

                            xhr.onload = function() {
                                if (this.status == 200) {
                                    var res = this.responseText;

                                    if(res){
                                        var users = JSON.parse(this.responseText);
                                        var userData = Object.values(users);

                                        console.log(userData);

                                    }

                                }

                                new Chart(document.getElementById("chartjs-0"), {
                                    "type": "bar",
                                    "data": {
                                        "labels": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                                        "datasets": [{
                                            "label": "Registrations",
                                            "data": userData,
                                            "fill": false,
                                            "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)","rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)"],
                                            "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)","rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)"],
                                            "borderWidth": 1
                                        }]
                                    },
                                    "options": {
                                        "scales": {
                                            "yAxes": [{
                                                "ticks": {
                                                    "beginAtZero": true
                                                }
                                            }]
                                        }
                                    }
                                });

                            }

                            xhr.send();
                        }

                            </script>
                        </div>
                    </div>
                    <!--/Graph Card-->
                </div>

            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Graph</h5>
                    </div>
                    <div class="p-5">
                        <canvas id="chartjs-1" class="chartjs" width="undefined" height="undefined"></canvas>
                        <script>
                        new Chart(document.getElementById("chartjs-1"), {
                            "type": "bar",
                            "data": {
                                "labels": ["January", "February", "March", "April", "May", "June", "July"],
                                "datasets": [{
                                    "label": "Likes",
                                    "data": [65, 59, 80, 81, 56, 55, 40],
                                    "fill": false,
                                    "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)","rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)"],
                                    "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)","rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)"],
                                    "borderWidth": 1
                                }]
                            },
                            "options": {
                                "scales": {
                                    "yAxes": [{
                                        "ticks": {
                                            "beginAtZero": true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                    </div>
                </div>
                <!--/Graph Card-->
            </div>

            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Graph Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Graph</h5>
                    </div>
                    <div class="p-5"><canvas id="chartjs-4" class="chartjs" width="undefined" height="undefined"></canvas>
                        <script>
                        new Chart(document.getElementById("chartjs-4"), {
                            "type": "doughnut",
                            "data": {
                                "labels": ["P1", "P2", "P3"],
                                "datasets": [{
                                    "label": "Issues",
                                    "data": [300, 50, 100],
                                    "backgroundColor": ["rgb(255, 99, 132)", "rgb(54, 162, 235)", "rgb(255, 205, 86)"]
                                }]
                            }
                        });
                        </script>
                    </div>
                </div>
                <!--/Graph Card-->
            </div>

            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <!--Template Card-->
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Template</h5>
                    </div>
                    <div class="p-5">

                    </div>
                </div>
                <!--/Template Card-->
            </div>




        </div>

        <!--/ Console Content-->

    </div>


</div>
<!--/container-->
@endsection

