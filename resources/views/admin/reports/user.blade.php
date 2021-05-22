@extends('layouts.admin')

@section('content')
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <h1>Users Reports: <span id="y_span"></span> [ <span id="s_span"></span> - <span id="e_span"></span> ]</h1>
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
                    <option value="7">Aughust</option>
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
                    <option value="7">Aughust</option>
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
        {{-- USER REGISTRATION LINE CHART --}}
        <div class="bg-white border rounded shadow mt-20 h-1/2">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">New Users</h5>
            </div>
            <div class="flex flex-wrap">
                <div class="pt-5 pl-20 p-5 w-1/2">
                    <ol id="registration_list" class="list-decimal">

                    </ol>
                </div>
                <div class="p-5 h-1/2 w-1/2">
                    <canvas id="line-chart" width="800" height="450"></canvas>
                </div>
            </div>

        </div>
        {{-- DOUGHNUT CHART --}}
        <div class="bg-white border rounded shadow h-1/2">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">New Users</h5>
            </div>
            <div class="w-1/2">
                <canvas id="doughnut-chart" width="800" height="450"></canvas>
            </div>
        </div>
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
            const year_span = document.getElementById('y_span');
            const start_span = document.getElementById('s_span');
            const end_span = document.getElementById('e_span');
            error_flash.innerText = '';

            if(parseInt(start_input.value) >= parseInt(end_input.value)){
                error_flash.innerText = 'Invalid Query';
                return;
            }
            year_span.innerText = year_input.value;
            start_span.innerText = 'M'+(parseInt(start_input.value) + 1);
            end_span.innerText = 'M'+(parseInt(end_input.value) + 1);

            get_registrations();
            get_users();

            function get_registrations() {
                // CREATE XHR
                let api_url = '/admin/reports/users/api?year=' + year_input.value + '&start=' + start_input.value + '&end=' + end_input.value;
                let xhr = new XMLHttpRequest();
                xhr.open("GET", api_url, true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        let res = this.responseText;
                        document.getElementById("registration_list").innerHTML = "";
                        console.log(res);
                        if(res){
                            // CHART DATA
                            let users = JSON.parse(this.responseText);
                            let user_data = Object.values(users);
                            let user_labels = Object.keys(users);
                            // LIST
                            Object.entries(users).forEach(function([key, value]) {
                                let list_item = document.createElement("li");
                                let list_text = document.createTextNode(key + ': ' + value);
                                list_item.appendChild(list_text);
                                document.getElementById("registration_list").appendChild(list_item);
                            });
                            // CHART
                            new Chart(document.getElementById("line-chart"), {
                                type: 'line',
                                data: {
                                    labels: user_labels,
                                    datasets: [{
                                        data: user_data,
                                        label: "Registrations",
                                        borderColor: "#3e95cd",
                                        fill: false
                                    }]
                                },
                                options: {
                                    title: {
                                    display: true,
                                    text: 'User Registrations'
                                    }
                                }
                            });

                        }
                    }
                }
                xhr.send();
            }

            function get_users(){
                let api_url = '/admin/reports/users/api?year=' + year_input.value + '&start=' + start_input.value + '&end=' + end_input.value;
                let xhr2 = new XMLHttpRequest();
                xhr2.open("GET", api_url, true);
                xhr2.onload = function() {
                    if (this.status == 200) {
                        let res = this.responseText;
                        console.log(res);
                        if(res){
                            // CHART DATA
                            let users = JSON.parse(this.responseText);
                            let user_data = Object.values(users);
                            let user_labels = Object.keys(users);

                            new Chart(document.getElementById("doughnut-chart"), {
                                type: 'doughnut',
                                data: {
                                    labels: user_labels,
                                    datasets: [
                                        {
                                        label: "Population (millions)",
                                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                        data: user_data
                                        }
                                    ]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Predicted world population (millions) in 2050'
                                    }
                                }
                            });
                        }
                    }
                }
                xhr2.send();
            }

        }
    );
    console.log('AF Func');
</script>

@endsection
