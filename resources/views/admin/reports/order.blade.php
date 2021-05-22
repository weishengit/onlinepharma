@extends('layouts.admin')

@section('content')
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <h1>Order Reports: <span id="y_span"></span> [ <span id="s_span"></span> - <span id="e_span"></span> ]</h1>
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
        {{-- ORDER LINE CHART --}}
        <div class="bg-white border rounded shadow mt-4 h-1/2">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">STATS</h5>
            </div>
            <div class="flex flex-wrap p-2">
                <div class="border border-solid p-5"><h2 id="stat-orders"></h2></div>
                <div class="border border-solid p-5"><h2 id="stat-items"></h2></div>
                <div class="border border-solid p-5"><h2 id="stat-spending"></h2></div>
            </div>
        </div>
        {{-- ORDER LINE CHART --}}
        <div class="bg-white border rounded shadow mt-4 h-1/2">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">Orders</h5>
            </div>
            <div class="flex flex-wrap">
                <div class="pt-5 pl-20 p-5 w-1/2">
                    <div>
                        <h3 class="font-bold mb-4">Number of Orders</h3>
                        <ol id="order_list" class="list-decimal">

                        </ol>
                    </div>
                </div>
                <div class="p-5 h-1/2 w-1/2">
                    <canvas id="line-chart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
        {{-- TOP PRODUCT PIE CHART --}}
        <div class="bg-white border rounded shadow h-1/2">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">Product</h5>
            </div>
            <div class="flex flex-wrap">
                <div class="pt-5 pl-20 p-5 w-1/2">
                    <div>
                        <h3 class="font-bold mb-4">Most Bought Products</h3>
                        <ol id="product_list" class="list-decimal">

                        </ol>
                    </div>
                </div>
                <div class="p-5 h-1/2 w-1/2">
                    <canvas id="pie-chart" width="800" height="450"></canvas>
                </div>
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

            get_data();

            function get_data() {
                // CREATE XHR
                let api_url = '/admin/reports/orders/api?year=' + year_input.value + '&start=' + start_input.value + '&end=' + end_input.value;
                let xhr = new XMLHttpRequest();
                xhr.open("GET", api_url, true);

                xhr.onload = function() {
                    // CLEAR PREVIOUS DATA
                        document.getElementById("order_list").innerHTML = "";
                        document.getElementById("product_list").innerHTML = "";
                        document.getElementById("stat-orders").innerText = "";
                        document.getElementById("stat-items").innerText = "";
                        document.getElementById("stat-spending").innerText = "";

                    if (this.status == 200) {
                        var res = this.responseText;

                        if(res){
                            // GET JSON
                            let data = JSON.parse(this.responseText);
                            // STATS
                            document.getElementById("stat-orders").innerText = "Average Orders Per Customer:  " + data.data.avg_orders;
                            document.getElementById("stat-items").innerText = "Average Items Per Order:  " + data.data.avg_items;
                            document.getElementById("stat-spending").innerText = "Average Spending Per Order:  " + data.data.avg_spending;
                            // ORDER CHART DATA
                            let date_data = Object.values(data.data.orders_by_year);
                            let date_labels = Object.keys(data.data.orders_by_year);
                            // LIST
                            Object.entries(data.data.orders_by_year).forEach(function([key, value]) {
                                let list_item = document.createElement("li");
                                let list_text = document.createTextNode(key + ': ' + value);
                                list_item.appendChild(list_text);
                                document.getElementById("order_list").appendChild(list_item);
                            });
                            new Chart(document.getElementById("line-chart"), {
                                type: 'line',
                                data: {
                                    labels: date_labels,
                                    datasets: [{
                                        data: date_data,
                                        label: "Number of Orders",
                                        borderColor: "#3e95cd",
                                        fill: false
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Total Orders'
                                    }
                                }
                            });
                            // TOP PRODUCTS CHART
                            // DATA
                            let top_products = data.data.top10_products;
                            let top_data = Object.values(data.data.top10_products);
                            let top_labels = Object.keys(data.data.top10_products);
                            // LIST
                            Object.entries(data.data.top10_products).forEach(function([key, value]) {
                                let list_item = document.createElement("li");
                                let list_text = document.createTextNode(key + ': ' + value);
                                list_item.appendChild(list_text);
                                document.getElementById("product_list").appendChild(list_item);
                            });
                            // CHART
                            new Chart(document.getElementById("pie-chart"), {
                                type: 'pie',
                                data: {
                                labels: top_labels,
                                datasets: [{
                                    label: "Top 10 Products",
                                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                    data: top_data
                                }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Top 10 Products'
                                    }
                                }
                            });


                        }
                    }
                }
                xhr.send();
            }


        }
    );
</script>

@endsection
