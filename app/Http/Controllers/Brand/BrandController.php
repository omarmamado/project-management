<?php

namespace App\Http\Controllers\Brand;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id','desc')->latest()->get();
        $Categories = Category::all();
        return view('backend.brand.index',compact('brands','Categories'));//
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:200',
        ]);

        Brand::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return back()->with('success', 'Data has been create successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brands = Brand::find($id);
        $validatedData = $request->validate([
            'name'          => 'sometimes|max:200',
        ]);

        $brands->name = $request->input('name');
        $brands->category_id = $request->input('category_id');

        $brands->update();
        return back()->with('success', 'Data has been Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request)
    {
        Brand::find($request->id)->delete();

        return back()->with('success', 'Data has been deleted successfully.');
    }
}