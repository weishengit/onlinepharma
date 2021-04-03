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
        $categories = null;
        $title = '';

        if ($category == 'inactive') {
            // GETS INACTIVE CATEGORIES
            $categories = Category::where('is_active', 0)->where('id', '!=', 1)->get() ?? null;
            $title = 'Inactive';
        } else {
            // GETS ALL ACTIVE CATEGORIES
            $categories = Category::where('is_active', 1)->where('id', '!=', 1)->get() ?? null;
            $title = 'Active';
        }

        if ($categories == null) {
            return redirect()->route('admin.category.index')->with('message', 'there are currently no categories');
        }

        return view('admin.category.show')
            ->with('categories', $categories)
            ->with('title', $title);
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
            ->with('message', 'Category ' . $request->input('name') . ' has been created.');
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
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        Category::where('id', $id)
            ->update([
                'name' => $request->input('name'),
            ]);

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category ' . $request->input('name') . ' has been updated.');
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

        DB::transaction(function () use($category){
            // SET CATEGORY TO NONE
            Product::where('category_id', $category->id)
            ->update([
                'category_id' => 1
            ]);

            // DISABLE CATEGORY
             Category::where('id', $category->id)
            ->update([
                'is_active' => 0
            ]);
        });
        


        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category ' . $category->name . ' has been disabled.');
    }

    public function activate($id)
    {
        // CHECK IF CATEOGRY EXIST
        $category = Category::where('id', $id)->first() ?? null;
        if ($category == null) {
            return redirect()->route('admin.category.index')->with('message', 'category not found.');
        }
        $name = $category->name;

        category::where('id', $id)
            ->update([
                'is_active' => 1,
            ]);

        return redirect()->route('admin.category.index')->with('message', $name . ' has been reactivated');
    }
}
