<?php

namespace App\Http\Controllers\Project;

use App\Models\Form;
use App\Models\User;
use App\Models\Project;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = auth()->user();
    
        $users = User::all();
        $managers = User::where('is_manager', true)->get();
    
        $query = Project::query();
    
        if (in_array($user->role, ['gm', 'hr'])) {
            $projects = $query->orderBy('created_at', 'desc')->get(); 
        } else {
            $projects = $query->where(function ($q) use ($user) {
                $q->where('creator_id', $user->id)
                  ->orWhere('manager_id', $user->id); 
            })->orderBy('created_at', 'desc')->get(); 
        }
    
        return view('backend.projects.index', compact('projects',  'users', 'managers'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id', 
            'note' => 'nullable|string', 
        ]);
    
        $project = new Project();
        $project->name = $request->input('name');
        $project->note = $request->input('note');
        $project->manager_id = $request->input('manager_id');
        $project->creator_id = auth()->id(); 
        $project->status = 'project_not_started'; 
        $project->save();
    
        return redirect()->route('projects.index')->with('success', 'Project added successfully!');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id', 
            'note' => 'nullable|string', 
        ]);
    
        $project = Project::findOrFail($id);
        
        $project->name = $request->input('name');
        $project->note = $request->input('note');
        $project->manager_id = $request->input('manager_id');
        $project->status = $project->status; 
        $project->save();
    
        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addUsers(Request $request, $id)
{
    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
    ]);
    
    $project = Project::findOrFail($id);
    
    $project->users()->syncWithoutDetaching($request->user_ids);
    return redirect()->route('projects.index')->with('success', 'Data has been created successfully.');
}


}
