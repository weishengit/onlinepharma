<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name', 'ASC')->get() ?? null;

        return view('admin.product.index')
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // GET THE AVAILABLE CATEGORIES
        $categories = Category::orderBy('name', 'asc')->get() ?? null;
        $taxes = Tax::orderBy('name', 'asc')->get() ?? null;

        return view('admin.product.create')
            ->with('categories', $categories)
            ->with('taxes', $taxes);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // VALIDATE PRODUCT
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category' => 'nullable',
            'tax' => 'nullable',
            'generic_name' => 'nullable|string|max:255',
            'drug_class' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'critical_level' => 'required|numeric',
            'measurement' => 'required|string|max:255',
            'is_prescription' => 'required|numeric',
            'is_available' => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png|max:1096'
        ]);
        // MOVE IMAGE TO PUBLIC FOLDER
        $newImageName = null;

        if ($request->image != null) {
            $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $newImageName);
        }

        // CREATE PRODUCT
        Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'tax_id' => $request->input('tax'),
            'generic_name' => $request->input('generic_name'),
            'drug_class' => $request->input('drug_class'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'critical_level' => $request->input('critical_level'),
            'measurement' => $request->input('measurement'),
            'is_prescription' => $request->input('is_prescription'),
            'is_available' => $request->input('is_available'),
            'image' => $newImageName ?? 'no-image.jpg',
        ]);

        // REDIRECT TO PRODUCT INDEX
        return redirect()->route('admin.product.index')->with('message', $request->name . ' has been saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product = null)
    {
        $products = null;
        $title = '';

        if ($product == 'inactive') {
            // GETS INACTIVE CATEGORIES
            $products = Product::where('is_active', 0)->get() ?? null;
            $title = 'Inactive';
        }
        else if ($product == 'untaxed') {
            // GETS UNTAXED CATEGORIES
            $products = Product::where('is_active', 1)
                                    ->where(function($query) {
                                        $query->where('tax_id', 0)
                                                ->orWhere('tax_id', 1)
                                                ->orWhere('tax_id', null);
                                })->get() ?? null;
            $title = 'No Tax Set';
        }
        else if ($product == 'uncategorized') {
            // GETS UNTAXED CATEGORIES
            $products = Product::where('is_active', 1)
                                    ->where(function($query){
                                        $query->where('category_id', 0)
                                                ->orWhere('category_id', 1)
                                                ->orWhere('category_id', null);
                                    })->get() ?? null;
            $title = 'No Category Set';
        }
        else{
            // GETS ALL ACTIVE CATEGORIES
            $products = Product::where('is_active', '1')->get() ?? null;
            $title = 'Active';
        }

        if ($product == null) {
            return redirect()->route('admin.category.index')->with('message', 'there are currently no products');
        }

        return view('admin.product.show')
            ->with('products', $products)
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // GET THE AVAILABLE CATEGORIES
        $categories = Category::orderBy('name', 'ASC')->get() ?? null;
        $taxes = Tax::orderBy('name', 'ASC')->get() ?? null;
        $product = Product::where('id', $id)->first() ?? null;

        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }

        return view('admin.product.edit')
            ->with('product', $product)
            ->with('categories', $categories)
            ->with('taxes', $taxes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // VALIDATE PRODUCT
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'. $id,
            'category' => 'nullable',
            'tax' => 'nullable',
            'generic_name' => 'nullable|string|max:255',
            'drug_class' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'critical_level' => 'required|numeric',
            'measurement' => 'required|string|max:255',
            'is_prescription' => 'required|numeric',
            'is_available' => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png|max:1096'
        ]);
        // MOVE IMAGE TO PUBLIC FOLDER
        $product = Product::where('id', $id)->first();

        $oldPicture = $product->image;
        $newImageName = null;


        if ($request->image != null) {
            $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
        }

        DB::transaction(function () use($request, $oldPicture, $newImageName, $id, $product) {

            // IF USER SENT IMAGE
            if ($newImageName != null) {
                // CREATE IMAGE
                $request->image->move(public_path('images'), $newImageName);

                // REMOVE OLD IMAGE IF NOT PLACEHOLDER
                if ($product->image != 'no-image.jpg') {
                    File::delete(public_path('images/'. $oldPicture));
                }
            }

            // UPDATE PRODUCT
            Product::where('id', $id)
                ->update([
                'name' => $request->input('name'),
                'category_id' => $request->input('category'),
                'tax_id' => $request->input('tax'),
                'generic_name' => $request->input('generic_name'),
                'drug_class' => $request->input('drug_class'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'critical_level' => $request->input('critical_level'),
                'measurement' => $request->input('measurement'),
                'is_prescription' => $request->input('is_prescription'),
                'is_available' => $request->input('is_available'),
                'image' => $newImageName ?? $oldPicture,
            ]);


        });

        // REDIRECT TO PRODUCT INDEX
        return redirect()->route('admin.product.index')->with('message', $request->name . ' has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // CHECK IF PRODUCT EXIST
        $product = Product::where('id', $id)->first() ?? null;
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }
        $name = $product->name;

        // CHECK IF PRODUCT IS ACTIVE
        if ($product->is_active == 0) {
            return redirect()->route('admin.product.index')->with('message', $name . ' is already inactive.');
        }

        // DEACTIVATE PRODUCT
        Product::where('id', $id)
            ->update([
                'is_active' => 0
            ]);

        return redirect()->route('admin.product.index')->with('message', $name . ' has been deactivated');
    }
    /**
     * Mark the specified resource as activated.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        // CHECK IF PRODUCT EXIST
        $product = Product::where('id', $id)->first() ?? null;
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }
        $name = $product->name;

        Product::where('id', $id)
        ->update([
            'is_active' => 1,
        ]);

        return redirect()->route('admin.product.index')->with('message', $name . ' has been reactivated');
    }

}
