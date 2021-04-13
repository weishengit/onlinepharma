<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function index()
    {
        $topProducts = Product::where('is_available', 1)->where('is_active', 1)->orderBy('name', 'ASC')->limit(6)->get();
        $newProducts = Product::where('is_available', 1)->where('is_active', 1)->orderBy('created_at', 'DESC')->limit(6)->get();

        return view('index')
            ->with('metaTitle', 'Home')
            ->with('topProducts', $topProducts)
            ->with('newProducts', $newProducts);
    }
    public function contact()
    {
        return view('pages.contact')
            ->with('metaTitle', 'Contact');
    }

    public function sales()
    {
        return view('pages.sales')
            ->with('metaTitle', 'Sales');
    }

    public function about()
    {
        return view('pages.about')
            ->with('metaTitle', 'About');
    }

    public function shop($filter = 'none')
    {
        $products = Product::where('is_active', 1)->where('is_available', 1)->paginate(12);

        if ($filter == 'name_asc') {
            $products = Product::where('is_active', 1)->where('is_available', 1)->orderBy('name', 'asc')->paginate(12);
        }
        if ($filter == 'name_desc') {
            $products = Product::where('is_active', 1)->where('is_available', 1)->orderBy('name', 'desc')->paginate(12);
        }
        if ($filter == 'price_asc') {
            $products = Product::where('is_active', 1)->where('is_available', 1)->orderBy('price', 'asc')->paginate(12);
        }
        if ($filter == 'price_desc') {
            $products = Product::where('is_active', 1)->where('is_available', 1)->orderBy('price', 'desc')->paginate(12);
        }

        return view('pages.shop')
            ->with('metaTitle', 'Shop')
            ->with('products', $products);
    }

    public function checkout()
    {
        return view('pages.checkout')
            ->with('metaTitle', 'Checkout');
    }

    public function thanks()
    {
        return view('pages.thanks')
            ->with('metaTitle', 'Thanks');
    }


    public function show($id)
    {
        $product = Product::find($id);
        if ($product->is_active == 0 || $product->is_available == 0) {
            return redirect()->route('home');
        }
        return view('pages.show')
            ->with('metaTitle', 'Shop - ' . $product->name)
            ->with('product', $product);
    }

    public function search(Request $request)
    {
        $filter = $request->input('filter');
        $newstr = filter_var($filter, FILTER_SANITIZE_STRING);

        if ($filter == '') {
            return '';
        }

        $name = '';
        $generic = '';
        $class = '';

        /**
         * The LIKE is case sensitive on PosgresSQL use ILIKE for case insensitive operation.
         *
         * This is a debug option remove if the database type is final
         *
         * set $db to 'mysql' or 'pgsql'
         */
        $db = 'pgsql';

        if ($db = 'mysql') {
            //-----------------------MYSQL CODE--------------------------//
            //CHECK NAME
            $name = Product::where('is_available', 1)
                ->where('is_active', 1)
                ->where('name', 'like', '%' . $newstr . '%')
                ->limit(10)->get();

            //CHECK GENERIC NAME
            $generic = Product::where('is_available', 1)
            ->where('is_active', 1)
            ->where('generic_name', 'like', '%' . $newstr . '%')
            ->limit(10)->get();

            //CHECK DRUG CLASS
            $class = Product::where('is_available', 1)
            ->where('is_active', 1)
            ->where('drug_class', 'like', '%' . $newstr . '%')
            ->limit(10)->get();
            //-----------------------MYSQL CODE--------------------------//
        }
        else
        {
            //-----------------------PGSQL CODE--------------------------//
            //CHECK NAME
            $name = Product::where('is_available', 1)
                ->where('is_active', 1)
                ->where('name', 'ilike', '%' . $newstr . '%')
                ->limit(10)->get();

            //CHECK GENERIC NAME
            $generic = Product::where('is_available', 1)
            ->where('is_active', 1)
            ->where('generic_name', 'ilike', '%' . $newstr . '%')
            ->limit(10)->get();

            //CHECK DRUG CLASS
            $class = Product::where('is_available', 1)
            ->where('is_active', 1)
            ->where('drug_class', 'ilike', '%' . $newstr . '%')
            ->limit(10)->get();
            //-----------------------PGSQL CODE--------------------------//
        }


        //-----------------------OLD CODE--------------------------//
        //  OLD CODE DOES NOT WORK ON HEROKU PGSQL ONLY FILTERS BY DRUGCLASS
        // $products = Product::where('is_available', 1)
        // ->where('is_active', 1)
        // ->where(function($query) use($newstr) {
        //     $query->orwhere('name', 'like', '%'.$newstr.'%')
        //     ->orwhere('generic_name', 'like', '%'.$newstr.'%')
        //     ->orwhere('drug_class', 'like', '%'.$newstr.'%');
        // })->limit(10)->get();
        //-----------------------OLD CODE--------------------------//

        $popo = ['name' => $name, 'generic' => $generic, 'class' => $class];
        $json = json_encode($popo);

        return $json;
    }
}
