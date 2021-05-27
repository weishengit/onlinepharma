<style>
    table.GeneratedTable {
      width: 100%;
      background-color: #ffffff;
      border-collapse: collapse;
      border-width: 2px;
      border-color: #000000;
      border-style: inset;
      color: #000000;
    }

    table.GeneratedTable td, table.GeneratedTable th {
      border-width: 2px;
      border-color: #000000;
      border-style: inset;
      padding: 3px;
    }

    table.GeneratedTable thead {
      background-color: #ffffff;
    }


    .page-break {
        page-break-after: always;
    }
</style>

{{-- HEAD --}}
<table style="width: 100%;" >
    <tbody>
    <tr>
    <td><h2>Orders Report: {{ $year->year }} {{ "[". $month_name[$month_start] . '-' . $month_name[$month_end] ."]" }}</h2></td>
    <td>Generated: {{ now()->toDateString() }}</td>
    </tr>
    </tbody>
</table>
{{-- STATS --}}
<h3>Statistics</h3>
<table class="GeneratedTable">
    <thead>
    <tr>
        <th>Total Orders</th>
        <th>Total Items Sold</th>
        <th>Total Earnings</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $number_of_orders }}</td>
        <td>{{ $number_of_items }}</td>
        <td>{{ $price_of_orders }}</td>
    </tr>
    </tbody>
</table>
<table class="GeneratedTable">
    <thead>
    <tr>
        <th>Avg Orders Per Customer</th>
        <th>Avg Items Per Order</th>
        <th>Avg Spending Per Order</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $avg_orders }}</td>
        <td>{{ round($avg_items, 2) }}</td>
        <td>{{ round($avg_spending, 2) }}</td>
    </tr>
    </tbody>
</table>
<br>
{{-- NUMBER OF ORDERS --}}
<h3>Number of Orders</h3>
<table class="GeneratedTable">
    <thead>
    <tr>
        <th>Month</th>
        <th>Total Orders</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order_array as $key => $value)
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $value }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{{-- NUMBER OF ORDERS --}}
<div class="page-break"></div>
<h3>Top Products</h3>
<table class="GeneratedTable">
    <thead>
    <tr>
        <th>Product</th>
        <th>Total Sold</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($product_results as $key => $value)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $value }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

