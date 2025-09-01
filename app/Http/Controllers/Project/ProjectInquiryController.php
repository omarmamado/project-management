<?php

namespace App\Http\Controllers\Project;

use Log;
use App\Models\Tag;
use App\Models\Form;
use App\Models\User;
use App\Models\Project;
use App\Models\PhaseTag;
use Illuminate\Http\Request;
use App\Models\ProjectInquiry;
use App\Models\ProjectInquiryPhase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
    
        $forms = Form::all();
        $users = User::all();
        $managers = User::where('is_manager', true)->get();
    
        $query = ProjectInquiry::query();
    
        if (in_array($user->role, ['gm', 'hr'])) {
            // إضافة Pagination حتى في حالة GM أو HR
            $projects = $query->orderBy('created_at', 'desc')->get();
        } else {
            $projects = $query->where(function ($q) use ($user) {
                $q->where('creator_id', $user->id)
                  ->orWhere('manager_id', $user->id); 
            })->orderBy('created_at', 'desc')->get(); 
        }
    
        return view('backend.project_inquiries.index', compact('projects', 'forms', 'users', 'managers'));
    }
    
    

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $forms = Form::all();
    
        $existingTags = ProjectInquiryPhase::all(); 
    
        return view('backend.project_inquiries.create', compact('users', 'forms', 'existingTags'));
    }

 



public function store(Request $request)
{
    // dd($request->all());
    // التحقق من المدخلات
    $validated = $request->validate([
        'name' => 'required|string',
        'manager_id' => 'required|exists:users,id',
        'phases' => 'required|array',
        'phases.*.name' => 'required|string',
        'phases.*.manager_id' => 'required|exists:users,id',
        'phases.*.start_date' => 'nullable|date',
        'phases.*.end_date' => 'nullable|date',
        'phases.*.form_id' => 'required|exists:forms,id',
        'phases.*.tags' => 'nullable|array', // التأكد من أن التاجات هي مصفوفة
        'phases.*.tags.*' => 'string', // التأكد من أن التاجات هي قيم نصية
    ]);

    // إنشاء Project Inquiry
    $inquiry = ProjectInquiry::create([
        'name' => $validated['name'],
        'creator_id' => auth()->id(),
        'manager_id' => $validated['manager_id'],
        'creator_status' => 'pending',
        'manager_status' => 'pending',
    ]);

    // تخزين الـ phases مع التاجات
    foreach ($validated['phases'] as $phaseData) {
        // تخزين Phase
        $projectPhase = ProjectInquiryPhase::create([
            'project_inquiry_id' => $inquiry->id,
            'name' => $phaseData['name'],
            'manager_id' => $phaseData['manager_id'],
            'start_date' => $phaseData['start_date'] ?? null,
            'end_date' => $phaseData['end_date'] ?? null,
            'form_id' => $phaseData['form_id'],
            'status' => 'pending',
        ]);

        // إضافة التاجات إلى جدول phase_tags
        if (isset($phaseData['tags']) && is_array($phaseData['tags'])) {
            foreach ($phaseData['tags'] as $tag) {
                PhaseTag::create([
                    'phase_id' => $projectPhase->id,
                    'tag' => $tag,
                ]);
            }
        }
    }

    return redirect()->route('project_inquiry.index')->with('success', 'Project Inquiry and phases created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = ProjectInquiry::find($id);
    
        $dynamicData = !empty($project->dynamic_data) ? json_decode($project->dynamic_data, true) : [];

        if (json_last_error() !== JSON_ERROR_NONE) {
            dd('JSON Error: ' . json_last_error_msg());
        }
    
        // تحميل الفورم المرتبط
        $form = $project->form;
    
        if (!$form || empty($form->fields)) {
            return redirect()->route('project_inquiry.index')->with('error', 'لم يتم العثور على الفورم المرتبطة');
        }
    
        $dynamicFields = json_decode($form->fields, true);
      

        if (empty($dynamicFields)) {
            return redirect()->route('project_inquiry.index')->with('error', 'لا توجد حقول  مرتبطة بهذا الفورم');
        }
    
        return view('backend.project_inquiries.show', compact('form', 'dynamicData', 'dynamicFields', 'project'));
    }

   
    
    public function edit($id)
    {
        // $project = ProjectInquiry::find($id);
    
        // $dynamicData = !empty($project->dynamic_data) ? json_decode($project->dynamic_data, true) : [];

        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     dd('JSON Error: ' . json_last_error_msg());
        // }
    
        // // تحميل الفورم المرتبط
        // $form = $project->form;
    
        // if (!$form || empty($form->fields)) {
        //     return redirect()->route('project_inquiry.index')->with('error', 'لم يتم العثور على الفورم المرتبطة');
        // }
    
        // $dynamicFields = json_decode($form->fields, true);
      

        // if (empty($dynamicFields)) {
        //     return redirect()->route('project_inquiry.index')->with('error', 'لا توجد حقول  مرتبطة بهذا الفورم');
        // }
    
        // return view('backend.project_inquiries.edit', compact('form', 'dynamicData', 'dynamicFields', 'project'));

        
        //  $project = ProjectInquiry::find($id);
        // $users = User::all();
        // $forms = Form::all();
    
        // $existingTags = ProjectInquiryPhase::all(); 
    
        // return view('backend.project_inquiries.edit', compact('users', 'forms', 'existingTags', 'project'));
        $project = ProjectInquiry::with('phases.tags')->findOrFail($id);

        $users = User::all();
        $forms = Form::all();
        $existingTags = ProjectInquiryPhase::all(); 
    
        return view('backend.project_inquiries.edit', compact('users', 'forms', 'project', 'existingTags'));

    }
    

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $projectInquiry = ProjectInquiry::find($id);
    
    //     if (!$projectInquiry) {
    //         return redirect()->route('project_inquiry.index')->with('error', 'لم يتم العثور على استفسار المشروع');
    //     }
    
    //     $status = $request->input('status');
        
    //     $startDateManager = $request->input('start_date_manager') ?: $projectInquiry->start_date;
    //     $endDateManager = $request->input('end_date_manager') ?: $projectInquiry->end_date;
    
    //     if ($status == 'approved') {
    //         $projectInquiry->status = 'approved';
    //         $projectInquiry->start_date_manager = $startDateManager; 
    //         $projectInquiry->end_date_manager = $endDateManager; 
            
    //         $project = new Project();
    //         $project->name = $projectInquiry->name;
    //         $project->creator_id = $projectInquiry->creator_id;
    //         $project->manager_id = $projectInquiry->manager_id;
    //         $project-> project_inquiries_id = $projectInquiry->id;
    //         $project->status = 'project_not_started';

    //         $project->save();
    //     } elseif ($status == 'rejected') {
    //         $projectInquiry->status = 'rejected';
    //         $projectInquiry->end_date_manager = $endDateManager; 
    //     }
    
    //     $projectInquiry->save();
    
    //     return redirect()->route('project_inquiry.index')->with('success', 'تم تحديث حالة استفسار المشروع بنجاح');
    // }

    public function update(Request $request, $id)
    {
        // التحقق من المدخلات
        $validated = $request->validate([
            'name' => 'required|string',
            'manager_id' => 'required|exists:users,id',
            'phases' => 'required|array',
            'phases.*.id' => 'nullable|exists:project_inquiry_phases,id', // التأكد من أن المرحلة موجودة إذا كان لديها ID
            'phases.*.name' => 'required|string',
            'phases.*.manager_id' => 'required|exists:users,id',
            'phases.*.start_date' => 'nullable|date',
            'phases.*.end_date' => 'nullable|date',
            'phases.*.form_id' => 'required|exists:forms,id',
            'phases.*.tags' => 'nullable|array',
            'phases.*.tags.*' => 'string',
        ]);
    
        // تحديث بيانات المشروع
        $inquiry = ProjectInquiry::findOrFail($id);
        $inquiry->update([
            'name' => $validated['name'],
            'manager_id' => $validated['manager_id'],
        ]);
    
        // معالجة كل مرحلة على حدة
        $existingPhaseIds = $inquiry->phases->pluck('id')->toArray();
        $updatedPhaseIds = collect($validated['phases'])->pluck('id')->filter()->toArray();
    
        // حذف المراحل التي لم تعد موجودة في الطلب
        $phasesToDelete = array_diff($existingPhaseIds, $updatedPhaseIds);
        ProjectInquiryPhase::whereIn('id', $phasesToDelete)->delete();
    
        // تحديث أو إنشاء المراحل
        foreach ($validated['phases'] as $phaseData) {
            if (isset($phaseData['id'])) {
                // تحديث المرحلة الموجودة
                $phase = ProjectInquiryPhase::findOrFail($phaseData['id']);
                $phase->update([
                    'name' => $phaseData['name'],
                    'manager_id' => $phaseData['manager_id'],
                    'start_date' => $phaseData['start_date'] ?? null,
                    'end_date' => $phaseData['end_date'] ?? null,
                    'form_id' => $phaseData['form_id'],
                ]);
    
                // تحديث التاجات الخاصة بهذه المرحلة فقط
                PhaseTag::where('phase_id', $phase->id)->delete();
                if (isset($phaseData['tags']) && is_array($phaseData['tags'])) {
                    foreach ($phaseData['tags'] as $tag) {
                        PhaseTag::create([
                            'phase_id' => $phase->id,
                            'tag' => $tag,
                        ]);
                    }
                }
            } else {
                // إنشاء مرحلة جديدة
                $newPhase = ProjectInquiryPhase::create([
                    'project_inquiry_id' => $inquiry->id,
                    'name' => $phaseData['name'],
                    'manager_id' => $phaseData['manager_id'],
                    'start_date' => $phaseData['start_date'] ?? null,
                    'end_date' => $phaseData['end_date'] ?? null,
                    'form_id' => $phaseData['form_id'],
                    'status' => 'pending',
                ]);
    
                // إضافة التاجات إلى المرحلة الجديدة
                if (isset($phaseData['tags']) && is_array($phaseData['tags'])) {
                    foreach ($phaseData['tags'] as $tag) {
                        PhaseTag::create([
                            'phase_id' => $newPhase->id,
                            'tag' => $tag,
                        ]);
                    }
                }
            }
        }
    
        return redirect()->route('project_inquiry.index')->with('success', 'تم تحديث المشروع والمراحل بنجاح!');
    }
    

    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getFields($id)
    {
        $form = Form::findOrFail($id);
        $fields = json_decode($form->fields); 
    
        Log::info('Fields:', (array) $fields); 
    
        return response()->json([
            'fields' => $fields,
        ]);
    }

    public function getFieldsedit($id)
    {
        // استرجاع الفورم بناءً على الـ id
        $form = Form::find($id);
    
        if (!$form) {
            return response()->json(['message' => 'لم يتم العثور على الفورم'], 404);
        }
    
        // التأكد من أن dynamic_data يحتوي على بيانات، إذا كانت null أو فارغة قد يكون هناك مشكلة في البيانات المخزنة
        $dynamicData = $form->dynamic_data;
    
        if ($dynamicData) {
            return response()->json([
                'dynamic_data' => $dynamicData
            ]);
        } else {
            return response()->json([
                'message' => 'لا توجد بيانات ديناميكية لهذا الفورم'
            ], 404);
        }
    }
    
    
    
 
    
    
}
