<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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

    public function show($filter = '')
    {
        $categories = '';

        switch($filter){
            case 'all' :
                $categories = Category::orderBy('name', 'ASC')->get();
            break;
            default:
                $categories = Category::orderBy('name', 'DESC')->get();
            break;
        }

        return view('admin.category.show')
            ->with('categories', $categories)
            ->with('filter', $filter);
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
            ->route('admin.category.show')
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
            ->route('admin.category.show')
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
        $category->delete();

        return redirect()
            ->route('admin.category.show')
            ->with('message', 'Category '. $name .' has been deleted.');
    }
}
