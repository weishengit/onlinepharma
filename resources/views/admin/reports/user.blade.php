@extends('layouts.admin')

@section('content')
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <h1>Users Reports</h1>
        <p id="filter-error" class="bg-red-400"></p>
        <br>
        <div class="flex flex-wrap overflow-hidden">

            <div class="pr-5 overflow-hidden">
                <label for="year">Year</label>
                <select id="year" name="year" id="year">
                    <?php $end = date('Y') ?>
                    @while ($end >= 1970 )
                        <option value="<?php echo $end ?>"><?php echo $end ?></option>
                        <?php $end-- ?>
                    @endwhile
                  </select>
            </div>

            <div class="pr-5 overflow-hidden">
                <label for="start_month">Start Month</label>
                <select id="start_month" name="start_month" id="start_month">
                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">Aughus</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                </select>
            </div>

            <div class="pr-5 overflow-hidden">
                <label for="end_month">End Month</label>
                <select id="end_month" name="end_month" id="end_month">
                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">Aughus</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                  </select>
            </div>

            <div class="pr-5 overflow-hidden">
                <button
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="button" id="submit_btn">
                    Submit
                </button>
            </div>

          </div>
        <!--Graph Card-->
        <div class="bg-white border rounded shadow mt-20">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">New Users</h5>
            </div>
            <div class="p-5">
                <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                {{-- CHART HERE --}}
            </div>
        </div>
        <!--/Graph Card-->
    </div>
</div>

<script>

    const submitBtn = document.getElementById('submit_btn');
    submitBtn.addEventListener('click',
        function send_filter() {

            const year_input = document.getElementById('year');
            const start_input = document.getElementById('start_month');
            const end_input = document.getElementById('end_month');
            const error_flash = document.getElementById('filter-error');
            error_flash.innerText = '';

            if(start_input.value >= end_input.value){
                error_flash.innerText = 'Invalid Query';
                return;
            }

            api_url = '/admin/reports/users/api?year=' + year_input.value + '&start=' + start_input.value + '&end=' + end_input.value;

            // CREATE XHR
            var xhr = new XMLHttpRequest();

            xhr.open("GET", api_url, true);

            xhr.onload = function() {
                if (this.status == 200) {
                    var res = this.responseText;

                    if(res){

                        var users = JSON.parse(this.responseText);
                        var user_data = Object.values(users);
                        var labels = Object.keys(users);

                        var data = {
                        labels: labels,
                        datasets: [
                            {
                            label: "New Registrations",
                            data: user_data,

                            borderColor: "rgba(255, 99, 132)",
                            }
                        ]
                        };

                        var config = {
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Yearly User Registration'
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            },
                        };

                        var myChart = new Chart(document.getElementById('chartjs-0'), config);
                    }
                }
            }

            xhr.send();
        }
    );
    console.log('AF Func');
</script>

@endsection
