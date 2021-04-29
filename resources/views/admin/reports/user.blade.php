@extends('layouts.admin')

@section('content')
<div class="container">

    <!--Graph Card-->
    <div class="bg-white border rounded shadow mt-20">
        <div class="border-b p-3">
            <h5 class="font-bold uppercase text-gray-600">Yearly User Comparison</h5>
        </div>
        <div class="p-5">
            <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>

            <script>
            // LOAD
            window.onload = function load_users() {

                // CREATE XHR
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "{{ route('users.yearly') }}", true);
                var userData = [];

                xhr.onload = function() {
                    if (this.status == 200) {
                        var res = this.responseText;

                        if(res){
                            var users = JSON.parse(this.responseText);
                            var label2 = "{{ now()->startOfYear()->year }}";
                            var label1 = "{{ now()->startOfYear()->subYear()->year }}";
                            var label1_data = Object.values(users[label1]);
                            var label2_data = Object.values(users[label2])
                                .filter(function(number) {
                                    return number > 0;
                                });
                            console.log(label1_data)

                            var labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            var data = {
                            labels: labels,
                            datasets: [
                                {
                                label: label1,
                                data: label1_data,

                                borderColor: "rgba(255, 99, 132)",
                                },
                                {
                                label: label2,
                                data: label2_data,
                                borderColor: "rgba(132, 99, 255)",
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

                </script>
        </div>
    </div>
    <!--/Graph Card-->
</div>
@endsection
