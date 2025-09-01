<?php

namespace App\Http\Controllers\Project;

use App\Models\Form;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectInquiry;
use App\Models\ProjectInquiryPhase;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProjectInquiryPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $project = ProjectInquiry::with('phases')->findOrFail($projectInquiryId);

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
    try {
        $phase = ProjectInquiryPhase::where('project_inquiry_id', $request->project_inquiry_id)
                                    ->where('form_id', $request->form_id)
                                    ->first();

        if ($phase) {
            // dd($phase);

            $existingData = $phase->dynamic_data ? json_decode($phase->dynamic_data, true) : [];

            $newData = is_array($request->dynamic_data) ? $request->dynamic_data : [];
            $updatedData = array_merge($existingData, $newData);
           
            // dd($phase);
            
            $updateResult = $phase->update([
                'dynamic_data' => json_encode($updatedData),
            ]);
            
            if (!$updateResult) {
                dd('Update failed');
            }
            


            return redirect()->route('project_inquiry.phases', ['project_inquiry' => $phase->project_inquiry_id])
                ->with('success', 'تم تحديث dynamic_data بنجاح');
        } else {
            return back()->withErrors(['error' => 'السجل المطلوب غير موجود']);
        }
    } catch (\Exception $e) {
        Log::error('حدث خطأ أثناء تحديث dynamic_data', ['error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = ProjectInquiry::findOrFail($id); 
        return view('backend.phase.show', compact('project')) ; 
      }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phase = ProjectInquiryPhase::with('form')->findOrFail($id);
    
        $formFields = json_decode($phase->form->fields, true);
    
        $dynamicData = json_decode($phase->dynamic_data, true);
    
        return view('backend.phase.create', compact('phase', 'formFields', 'dynamicData'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

 
//     public function showPhases($projectInquiryId)
// {
//     // جلب المشروع مع المراحل والمستخدمين المرتبطين بها
//     $project = ProjectInquiry::with(['phases.users', 'phases.manager.department.users'])->findOrFail($projectInquiryId);

//     $users = [];
//     foreach ($project->phases as $phase) {
//         if ($phase->manager->department->team_id) {
//             // جلب أعضاء الفريق
//             $users[$phase->id] = $phase->teamMembers;
//         } else {
//             // جلب جميع المستخدمين في القسم إذا لم تكن هناك فرق
//             $users[$phase->id] = $phase->manager->department->users;
//         }
//     }

//     return view('backend.phase.phase', compact('project', 'users'));
// }
public function showPhases($projectInquiryId)
{
    // Retrieve the project with related phases and users
    $project = ProjectInquiry::with(['phases.users', 'phases.manager.department.users'])->findOrFail($projectInquiryId);

    $users = [];
    foreach ($project->phases as $phase) {
        // Check if the manager has a department
        if ($phase->manager && $phase->manager->department) {
            if ($phase->manager->department->team_id) {
                // Retrieve team members if team_id is present
                $users[$phase->id] = $phase->teamMembers;
            } else {
                // Retrieve all users in the department if no team_id
                $users[$phase->id] = $phase->manager->department->users;
            }
        } else {
            // Handle the case where manager or department is null
            $users[$phase->id] = []; // or some default value/behavior
        }
    }

    return view('backend.phase.phase', compact('project', 'users'));
}


public function detail($id)
{
    $phase = ProjectInquiryPhase::with('form')->findOrFail($id);

    $formFields = json_decode($phase->form->fields, true);
    
    $dynamicData = json_decode($phase->dynamic_data, true);
    return view('backend.phase.detail', compact('phase', 'formFields', 'dynamicData')); 
}


public function approveOrReject(Request $request, $id)
{
    $phase = ProjectInquiryPhase::findOrFail($id);

    if ($request->has('approve')) {
        $phase->status = 'approved';
    } elseif ($request->has('reject')) {
        $phase->status = 'rejected';
    }

    $phase->save();

    $projectInquiry = $phase->projectInquiry;

    return redirect()->route('project_inquiry.phases', ['project_inquiry' => $projectInquiry->id])
        ->with('success', 'Phase updated successfully.');
}
public function approveOrRejectdetail($id)
{
    $phase = ProjectInquiryPhase::with('form')->findOrFail($id);

    $formFields = json_decode($phase->form->fields, true);
    
    $dynamicData = json_decode($phase->dynamic_data, true);
    return view('backend.phase.approveOrRejectdetail', compact('phase', 'formFields', 'dynamicData')); 
}

// public function assignUsers(Request $request, $phaseId)
// {
//     $phase = ProjectInquiryPhase::findOrFail($phaseId);

//     // التحقق من اختيار المستخدمين
//     $users = $request->input('user_id', []);

//     // إضافة المستخدمين إلى المرحلة (افتراضًا أنه يتم تحديث علاقة كثيرة إلى كثيرة)
//     $phase->users()->sync($users);

//     return redirect()->back()->with('success', 'Users assigned successfully!');
// }

public function assignUsers(Request $request, $phaseId)
{
    $phase = ProjectInquiryPhase::findOrFail($phaseId);

    // التحقق من اختيار المستخدمين
    $users = $request->input('user_id', []);

    $phase->users()->sync($users);

    if (!empty($users)) {
        $projectInquiry = $phase->projectInquiry;  

        if ($projectInquiry) {
            $existingProject = Project::where('project_inquiries_id', $projectInquiry->id)->first();

            if (!$existingProject) {
                // إنشاء مشروع جديد وربطه بالـ Project Inquiry
                Project::create([
                    'name' => $projectInquiry->name,
                    'creator_id' => $projectInquiry->creator_id,
                    'manager_id' => $projectInquiry->manager_id,
                    'project_inquiries_id' => $projectInquiry->id,
                    'is_from_inquiry' => true,
                    'status' => 'project_not_started',
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Project Inquiry not found.');
        }
    }

    return redirect()->back()->with('success', 'Users assigned successfully!');
}



}
