<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }

    public function show($category = null)
    {
        $categories = Category::orderBy('name', 'ASC')->get() ?? null;
        if ($categories == null) {
            return redirect()->route('admin.category.index')->with('message', 'there are currently no categories');
        }

        return view('admin.category.show')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->input('name'),
        ]);

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category '. $request->input('name') .' has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id', $id)->first() ?? null;

        if ($category == null) {
            return redirect()->route('admin.category.index')->with('message', 'Category not found.');
        }

        return view('admin.category.edit')
            ->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'. $id,
        ]);

        Category::where('id', $id)
            ->update([
                'name' => $request->input('name'),
            ]);

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category '. $request->input('name') .' has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->first()  ?? null;

        if ($category == null) {
            return redirect()->route('admin.category.index')->with('message', 'Category not found.');
        }
        $name = $category->name;

        // DELETE THE CATEGORY AND UNSET IT FROM PRODUCTS
        DB::transaction(function () use($category, $id){
            $category->delete();

            Product::where('category_id', $id)
                ->update([
                    'category_id' => null
                ]);
        });
        

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category '. $name .' has been deleted.');
    }
}
