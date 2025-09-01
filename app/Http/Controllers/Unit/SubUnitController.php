<?php

namespace App\Http\Controllers\Unit;

use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubUnitController extends Controller
{
    
    public function index()
    {
        $subUnits = SubUnit::orderBy('id', 'desc')->latest()->get();
        $units = Unit::all();
        return view('backend.subunit.index', compact('subUnits','units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:sub_units|max:200',
            'unit_id' => 'required|exists:units,id',
            'conversion_rate' => 'required|integer|min:1',
        ]);

        SubUnit::create([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'conversion_rate' => $request->conversion_rate,
        ]);

        $notification = array(
            'message' => 'تم إضافة الوحدة الفرعية بنجاح',
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
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subUnit = SubUnit::find($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|max:200',
            'unit_id' => 'required|exists:units,id',
            'conversion_rate' => 'required|integer|min:1',
        ]);

        $subUnit->name = $request->input('name');
        $subUnit->unit_id = $request->input('unit_id');
        $subUnit->conversion_rate = $request->input('conversion_rate');
        $subUnit->update();

        $notification = array(
            'message' => 'تم تحديث الوحدة الفرعية بنجاح',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        SubUnit::find($request->id)->delete();
        $notification = array(
            'message' => 'تم حذف الوحدة الفرعية بنجاح',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
