<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmployeeEvaluation;
use App\Http\Controllers\Controller;

class EmployeeEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $user = auth()->user();
    //     $evaluations = EmployeeEvaluation::where('user_id', $user->id)->latest()->get();
    //     return view('pages.employee_evaluations.index', compact('evaluations'));  
    //   }
    
    public function index()
    {
        $user = auth()->user();
    
        // إذا كان المستخدم HR أو GM، اعرض جميع التقييمات
        if ($user->role === 'hr' || $user->role === 'gm') {
            $evaluations = EmployeeEvaluation::all();
        } else {
            // إذا لم يكن المستخدم HR أو GM، نفذ المنطق التالي
            $evaluations = EmployeeEvaluation::where('user_id', $user->id)->get();
    
            if ($user->is_manager) {
                $department = $user->department;
    
                if ($department) {
                    // Check if the department has a team
                    $teamMembers = $department->users->where('id', '!=', $user->id);
    
                    if ($teamMembers->isEmpty()) {
                        $evaluations = EmployeeEvaluation::whereIn('user_id', $department->users->pluck('id'))->get();
                    } else {
                        // If the department has a team, show manager's and team's evaluations
                        $evaluations = EmployeeEvaluation::whereIn('user_id', $teamMembers->pluck('id'))
                            ->orWhere('user_id', $user->id) // Include manager's own evaluations
                            ->get();
                    }
                }
            }
        }
    
        return view('backend.employee_evaluations.index', ['evaluations' => $evaluations]);
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = auth()->user();
        return view('backend.employee_evaluations.create', compact('users')); 
         }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      // دالة store لإضافة تقييم جديد
      public function store(Request $request)
      {
        // dd($request->all());
          $user = auth()->user();
          $month = Carbon::now()->format('F Y'); // الشهر الحالي مثل "October 2024"
          $department = $user->department ? $user->department->name : 'General'; // اسم القسم إذا كان موجودًا
  
          // إنشاء اسم التقييم
          $evaluationName = "Employee Evaluation - {$user->name} - {$month} - {$department}";
  
          // إنشاء تقييم جديد
          EmployeeEvaluation::create([
              'name' => $evaluationName,
              'user_id' => $user->id,
              'initiative_flexibility' => $request->initiative_flexibility,
              'initiative_comment_employee' => $request->initiative_comment_employee,
              'initiative_comment_manager' => $request->initiative_comment_manager,
              'knowledge_position' => $request->knowledge_position,
              'knowledge_comment_employee' => $request->knowledge_comment_employee,
              'knowledge_comment_manager' => $request->knowledge_comment_manager,
              'time_effectiveness' => $request->time_effectiveness,
              'time_comment_employee' => $request->time_comment_employee,
              'time_comment_manager' => $request->time_comment_manager,
              'overall_rating' => $request->overall_rating,
              'overall_comment' => $request->overall_comment,

          ]);
  
          return redirect()->route('employee-evaluation.index')->with('success', 'تم إضافة التقييم بنجاح.');
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = EmployeeEvaluation::findOrFail($id); // جلب التقييم من قاعدة البيانات
        return view('backend.employee_evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluation = EmployeeEvaluation::findOrFail($id); // جلب التقييم من قاعدة البيانات
        return view('backend.employee_evaluations.edit', compact('evaluation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     // استرجاع المستخدم الحالي
    //     $user = auth()->user();
    
    //     // البحث عن التقييم الذي سيتم تعديله
    //     $evaluation = EmployeeEvaluation::findOrFail($id);
    
       
    
    //     // تحديث بيانات التقييم دون تعديل الاسم
    //     $evaluation->update([
    //         'initiative_flexibility' => $request->initiative_flexibility,
    //         'initiative_comment_employee' => $request->initiative_comment_employee,
    //         'initiative_comment_manager' => $request->initiative_comment_manager,
    //         'knowledge_position' => $request->knowledge_position,
    //         'knowledge_comment_employee' => $request->knowledge_comment_employee,
    //         'knowledge_comment_manager' => $request->knowledge_comment_manager,
    //         'time_effectiveness' => $request->time_effectiveness,
    //         'time_comment_employee' => $request->time_comment_employee,
    //         'time_comment_manager' => $request->time_comment_manager,
    //         'overall_rating' => $request->overall_rating,
    //     ]);
    
    //     // إعادة التوجيه مع رسالة نجاح
    //     return redirect()->route('employee-evaluation.index')->with('success', 'تم تعديل التقييم بنجاح.');
    // }
    public function update(Request $request, $id)
    {
        // البحث عن التقييم المطلوب
        $evaluation = EmployeeEvaluation::findOrFail($id);
    
        // تحديث البيانات فقط إذا كانت مرسلة
        $evaluation->initiative_flexibility = $request->input('initiative_flexibility', $evaluation->initiative_flexibility);
        $evaluation->initiative_comment_employee = $request->input('initiative_comment_employee', $evaluation->initiative_comment_employee);
        $evaluation->initiative_comment_manager = $request->input('initiative_comment_manager', $evaluation->initiative_comment_manager);
        $evaluation->knowledge_position = $request->input('knowledge_position', $evaluation->knowledge_position);
        $evaluation->knowledge_comment_employee = $request->input('knowledge_comment_employee', $evaluation->knowledge_comment_employee);
        $evaluation->knowledge_comment_manager = $request->input('knowledge_comment_manager', $evaluation->knowledge_comment_manager);
        $evaluation->time_effectiveness = $request->input('time_effectiveness', $evaluation->time_effectiveness);
        $evaluation->time_comment_employee = $request->input('time_comment_employee', $evaluation->time_comment_employee);
        $evaluation->time_comment_manager = $request->input('time_comment_manager', $evaluation->time_comment_manager);
        $evaluation->overall_rating = $request->input('overall_rating', $evaluation->overall_rating);
        $evaluation->overall_comment = $request->input('overall_comment', $evaluation->overall_comment);

    
        // حفظ التغييرات
        $evaluation->save();
    
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('employee-evaluation.index')->with('success', 'تم تعديل التقييم بنجاح.');
    }
    
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
