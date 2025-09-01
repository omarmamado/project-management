<?php

namespace App\Http\Controllers\Team;

use App\Models\Team;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams= Team::orderBy('id','desc')->latest()->get();
        $departments = Department::all();
        return view('backend.Team.index',compact('departments','teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:companies|max:200',
        ]);

        Team::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);
        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $departments = Team::find($id);
        $validatedData = $request->validate([
            'name'          => 'sometimes|max:200',
        ]);

        $departments->name = $request->input('name');
        $departments->department_id = $request->input('department_id');

        $departments->update();
        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request)
    {
        Team::find($request->id)->delete();

        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
