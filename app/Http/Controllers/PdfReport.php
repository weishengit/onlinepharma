<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class PdfReport extends Controller
{
    public function orders(Request $request)
    {
        $request->validate([
            'year' => 'numeric',
            'start' => 'numeric',
            'end' => 'numeric',
        ]);

        $year = $request->input('year') ?? null;
        $month_start = $request->input('start') ?? 0;
        $month_end = $request->input('end') ?? 11;
        $year = Carbon::createFromDate($year);

        if ($year == null) {
            $year = Carbon::now();
        }

        $start_date = $year->startOfYear();
        $end_date = $start_date->copy()->endOfYear();

        if (($month_start != null || $month_start >= 0) && $month_end != null) {
            $start_date->addMonths($month_start);
            $end_date = $start_date->copy()->addMonths($month_end)->endOfMonth();
        }
        // dd($start_date . ' - ' . $end_date);
        $order_count = [];
        $order_array = [];

        $orders = Order::whereBetween('created_at', [$start_date, $end_date])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
        });

        //dd($orders);
        $month_name = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        foreach ($orders as $key => $value) {
            $order_count[(int)$key] = count($value);
        }
        // dd($order_count);



        for($month = $month_start+1; $month <= $month_end + 1; $month++){
            if(!empty($order_count[$month])){
                $order_array[$month_name[$month-1]] = $order_count[$month];
            }else{
                $order_array[$month_name[$month-1]] = 0;
            }
        }
        // dd($order_array);
        // GET TO PRODUCTS
        $products = Item::whereBetween('created_at', [$start_date, $end_date])
            ->get()
            ->groupBy('product_id')->map(function($row){
                return $row->sum('quantity');
            }
        );

        $product_array = $products->toArray();
        arsort($product_array, SORT_NUMERIC);
        $product_array = array_slice($product_array, 0, 10, true);
        $product_results = [];
        foreach ($product_array as $key => $value) {
            $product = Product::find($key);
            $product_results[$product->name] = $value;
        }
        // AVERAGE SPENDING
        $total_orders = Order::whereBetween('created_at', [$start_date, $end_date])->get();
        $number_of_orders = $total_orders->count();
        $number_of_customer = Order::whereBetween('created_at', [$start_date, $end_date])->get()->groupBy('user_id')->count();
        $number_of_items = Order::select('total_items')->whereBetween('created_at', [$start_date, $end_date])->sum('total_items');
        $price_of_orders = Order::select('amount_due')->whereBetween('created_at', [$start_date, $end_date])->sum('amount_due');
        $avg_spending = $price_of_orders / $number_of_orders;
        $avg_items = $number_of_items / $number_of_orders;
        $avg_orders = $number_of_orders / $number_of_customer;


        $pdf = PDF::loadView('admin.pdf.orders',
            compact(
                'year',
                'month_name',
                'month_start',
                'month_end',
                'number_of_items',
                'price_of_orders',
                'number_of_orders',
                'avg_spending',
                'avg_items',
                'avg_orders',
                'product_results',
                'order_array',
            ));

        return $pdf->stream();
    }
}
