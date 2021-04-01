<?php

namespace App\Http\Controllers;

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
        $categories = Category::orderBy('name', 'ASC')->get() ?? null;


        return view('admin.product.create')->with('categories', $categories);
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
            'category_id' => 'nullable',
            'generic_name' => 'nullable|string|max:255',
            'drug_class' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'measurement' => 'required|string|max:255',
            'is_prescription' => 'required|numeric',
            'is_available' => 'required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png|max:1096'
        ]);
        // MOVE IMAGE TO PUBLIC FOLDER
        $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension(); 
        $request->image->move(public_path('images'), $newImageName);

        // CREATE PRODUCT
        Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'generic_name' => $request->input('generic_name'),
            'drug_class' => $request->input('drug_class'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'measurement' => $request->input('measurement'),
            'is_prescription' => $request->input('is_prescription'),
            'is_available' => $request->input('is_available'),
            'image' => $newImageName,
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
    public function show($id)
    {
        $product = Product::where('id', $id)->first() ?? null;
        
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }

        return view('admin.product.show')
            ->with('product', $product);
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
        $product = Product::where('id', $id)->first() ?? null;
        
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }

        return view('admin.product.edit')
            ->with('product', $product)
            ->with('categories', $categories);
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
            'category_id' => 'nullable',
            'generic_name' => 'nullable|string|max:255',
            'drug_class' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'measurement' => 'required|string|max:255',
            'is_prescription' => 'required|numeric',
            'is_available' => 'required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png|max:1096'
        ]);
        // MOVE IMAGE TO PUBLIC FOLDER
        $product = Product::where('id', $id)->first();
        $oldPicture = $product->image;
        $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();

        DB::transaction(function () use($request, $oldPicture, $newImageName, $id) {

            
            $request->image->move(public_path('images'), $newImageName);

            // CREATE PRODUCT
            Product::where('id', $id)
                ->update([
                'name' => $request->input('name'),
                'category_id' => $request->input('category'),
                'generic_name' => $request->input('generic_name'),
                'drug_class' => $request->input('drug_class'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'measurement' => $request->input('measurement'),
                'is_prescription' => $request->input('is_prescription'),
                'is_available' => $request->input('is_available'),
                'image' => $newImageName,
            ]);

            File::delete(public_path('images/'. $oldPicture));
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
        $product = Product::where('id', $id)->first() ?? null;
        if ($product == null) {
            return redirect()->route('admin.product.index')->with('message', 'product not found.');
        }
        $name = $product->name;
        $image =$product->image;
        File::delete(public_path('images/'. $image));
        $product->delete();

        return redirect()->route('admin.product.index')->with('message', $name . ' has been deleted');
    }
}
