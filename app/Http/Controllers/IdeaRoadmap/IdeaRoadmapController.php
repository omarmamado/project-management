<?php
namespace App\Http\Controllers\IdeaRoadmap;

use App\Http\Controllers\Controller;
use App\Models\IdeaRoadmap;
use App\Models\Project;
use Illuminate\Http\Request;

class IdeaRoadmapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        $roadmaps = IdeaRoadmap::with('project')->latest()->get();
        return view('backend.idea_roadmaps.index', compact('roadmaps', 'projects'));
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
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|max:10240',
        ]);

        $fileName = null;

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('idea_roadmaps'), $fileName);
        }

        IdeaRoadmap::create([
            'project_id'  => $request->project_id,
            'name'        => $request->name,
            'description' => $request->description,
            'file'        => $fileName,
            'created_by' => auth()->id(),

        ]);

        return redirect()->back()->with('success', 'Idea Roadmap saved successfully.');
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
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480', // 20MB max
        ]);

        $ideaRoadmap = IdeaRoadmap::findOrFail($id);

        $ideaRoadmap->name = $request->name;
        $ideaRoadmap->description = $request->description;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('idea_roadmaps'), $filename);
            $ideaRoadmap->file = $filename;
        }

        $ideaRoadmap->save();

        return redirect()->route('idea-roadmaps.index')->with('success', 'Idea Roadmap updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}