<?php

namespace App\Http\Controllers\Department;

use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('id','desc')->latest()->get();
        $companies = Company::all();
        return view('backend.Department.index',compact('companies','departments'));//
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
            'name' => 'required|unique:companies|max:200',
        ]);

        Department::create([
            'name' => $request->name,
            'company_id' => $request->company_id,
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
    public function update(Request $request, string $id)
    {
        $departments = Department::find($id);
        $validatedData = $request->validate([
            'name'          => 'sometimes|max:200',
        ]);

        $departments->name = $request->input('name');
        $departments->company_id = $request->input('company_id');

        $departments->update();
        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request)
    {
        Department::find($request->id)->delete();

        $notification = array(
            'message' => 'data added successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
   
    public function getTeamsOrManagers($departmentId)
    {
        $department = Department::with('teams')->find($departmentId);  // استخدام with لتحميل الفرق
    
        // تحقق من وجود القسم
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
    
        // الحصول على الفرق
        $teams = $department->teams;
    
        // إذا لم يكن هناك فرق، جلب المستخدمين الذين لديهم صلاحية is_manager
        if ($teams->isEmpty()) {
            $managers = User::where('department_id', $departmentId)
                            ->where('is_manager', true)
                            ->get();
        } else {
            $managers = null;  // إذا كان هناك فرق، لا حاجة لعرض المديرين
        }
    
        return response()->json([
            'teams' => $teams,
            'managers' => $managers
        ]);
    }
    public function getTeamManagers($teamId)
{
    // التحقق من وجود الفريق
    $team = Team::find($teamId);

    if (!$team) {
        return response()->json(['error' => 'Team not found'], 404);
    }

    // جلب المستخدمين الذين لديهم صلاحية is_manager في الفريق
    $managers = User::where('team_id', $teamId)
                    ->where('is_manager', true)
                    ->get();

    return response()->json([
        'managers' => $managers,
    ]);
}

    
    
}
