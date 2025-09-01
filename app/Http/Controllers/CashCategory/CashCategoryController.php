<?php

namespace App\Http\Controllers\CashCategory;

use App\Models\CashCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cash_categories = CashCategory::orderBy('id','desc')->latest()->get();
        return view('backend.cash-category.index',compact('cash_categories'));
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
            'name' => 'required|unique:cash_categories|max:200',
        ]);

        CashCategory::create([
            'name' => $request->name,
        ]);
        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
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
    public function update(Request $request, $id)
    {
        $Company = CashCategory::find($id);
        $validatedData = $request->validate([
            'name'          => 'sometimes|max:200',
        ]);

        $Company->name = $request->input('name');
        $Company->update();
        $notification = array(
            'message' => 'Data has been Update successfully.',
            'alert-type' => 'success'
        );
        return back()->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)    {
        {
            CashCategory::find($request->id)->delete();
            $notification = array(
                'message' => 'Data has been deleted successfully.',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }
}
