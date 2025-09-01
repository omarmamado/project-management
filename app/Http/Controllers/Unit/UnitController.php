<?php

namespace App\Http\Controllers\Unit;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{

  public function index()
    {
        $units = Unit::orderBy('id','desc')->latest()->get();
        return view('backend.Unit.index',compact('units'));//
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
            'name' => 'required|unique:units|max:200',
        ]);

        Unit::create([
            'name' => $request->name,
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
    public function update(Request $request, $id)
    {
        $Unit = Unit::find($id);
        $validatedData = $request->validate([
            'name'          => 'sometimes|max:200',
        ]);

        $Unit->name = $request->input('name');
        $Unit->update();
        return back()->with('success', 'Data has been Update successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)    {
        {
            Unit::find($request->id)->delete();

            return back()->with('success', 'Data has been deleted successfully.');
        }
    }
}