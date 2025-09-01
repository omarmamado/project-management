<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnnualEmployeeEvaluation;

class AnnualEmployeeEvaluationController extends Controller
{
   
    public function index()
    {
        $user = auth()->user();
    
        // إذا كان المستخدم HR أو GM
        if (in_array($user->role, ['gm', 'hr'])) {
            $evaluations = AnnualEmployeeEvaluation::with(['user', 'user.team', 'user.department'])
                ->orderBy('created_at', 'desc') 
                ->get();
        } 
        // إذا كان المستخدم مدير فريق
        elseif ($user->is_manager) {
            $evaluations = AnnualEmployeeEvaluation::with(['user', 'user.team', 'user.department'])
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('department_id', $user->department_id)
                          ->where(function ($query) use ($user) {
                              $query->where('team_id', $user->team_id)->orWhereNull('team_id');
                          });
                })
                ->orderBy('created_at', 'desc') 
                ->get();
        } 
        // إذا كان المستخدم موظفًا عاديًا
        else {
            $evaluations = AnnualEmployeeEvaluation::with(['user', 'user.team', 'user.department'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc') 
                ->get();
        }
    
        return view('backend.annual_employee_evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = auth()->user(); 
        $users = collect();
    
        if ($currentUser->team_id) {
            $users = User::where('team_id', $currentUser->team_id)->get();
        } elseif ($currentUser->department_id) {
            $users = User::where('department_id', $currentUser->department_id)
                         ->whereNull('team_id')
                         ->get();
        }
    
        return view('backend.annual_employee_evaluations.create', compact('users'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $month = Carbon::now()->format('F Y'); 

    $evaluatedUser = User::findOrFail($request->user_id);
    $department = $evaluatedUser->department ? $evaluatedUser->department->name : 'General'; 

    $evaluationName = "Annual Evaluation - {$evaluatedUser->name} - {$month} - {$department}";

        // dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'nullable|string',
            'quality_of_work' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'quality_of_work_comment_head' => 'nullable|string',
            'quality_of_work_comment_gm' => 'nullable|string',
            'discipline_punctuality' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'discipline_punctuality_comment_head' => 'nullable|string',
            'discipline_punctuality_comment_gm' => 'nullable|string',
            'problem_solving' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'problem_solving_comment_head' => 'nullable|string',
            'problem_solving_comment_gm' => 'nullable|string',
            'conflict_management' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'conflict_management_comment_head' => 'nullable|string',
            'conflict_management_comment_gm' => 'nullable|string',
            'time_effectiveness_time_responsiveness_availability' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'time_effectiveness_time_responsiveness_availability_comment_head' => 'nullable|string',
            'time_effectiveness_time_responsiveness_availability_comment_gm' => 'nullable|string',
            'initiative_flexibility' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'initiative_flexibility_comment_head' => 'nullable|string',
            'initiative_flexibility_comment_gm' => 'nullable|string',
            'cooperation_teamwork' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'cooperation_teamwork_comment_head' => 'nullable|string',
            'cooperation_teamwork_comment_gm' => 'nullable|string',
            'knowledge_of_position' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'knowledge_of_position_comment_head' => 'nullable|string',
            'knowledge_of_position_comment_gm' => 'nullable|string',
            'creativity_innovation' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'creativity_innovation_comment_head' => 'nullable|string',
            'creativity_innovation_comment_gm' => 'nullable|string',
            'performance_goals' => 'nullable|string',
            'over_all_rating' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'over_all_comment' => 'nullable|string',
        ]);
    
        $evaluation = new AnnualEmployeeEvaluation();
        $evaluation->user_id = $request->input('user_id');
        $evaluation->name = $evaluationName;
        $evaluation->quality_of_work = $request->input('quality_of_work');
        $evaluation->quality_of_work_comment_head = $request->input('quality_of_work_comment_head');
        $evaluation->quality_of_work_comment_gm = $request->input('quality_of_work_comment_gm');
        $evaluation->discipline_punctuality = $request->input('discipline_punctuality');
        $evaluation->discipline_punctuality_comment_head = $request->input('discipline_punctuality_comment_head');
        $evaluation->discipline_punctuality_comment_gm = $request->input('discipline_punctuality_comment_gm');
        $evaluation->problem_solving = $request->input('problem_solving');
        $evaluation->problem_solving_comment_head = $request->input('problem_solving_comment_head');
        $evaluation->problem_solving_comment_gm = $request->input('problem_solving_comment_gm');
        $evaluation->conflict_management = $request->input('conflict_management');
        $evaluation->conflict_management_comment_head = $request->input('conflict_management_comment_head');
        $evaluation->conflict_management_comment_gm = $request->input('conflict_management_comment_gm');
        $evaluation->time_effectiveness_time_responsiveness_availability = $request->input('time_effectiveness_time_responsiveness_availability');
        $evaluation->time_effectiveness_time_responsiveness_availability_comment_head = $request->input('time_effectiveness_time_responsiveness_availability_comment_head');
        $evaluation->time_effectiveness_time_responsiveness_availability_comment_gm = $request->input('time_effectiveness_time_responsiveness_availability_comment_gm');
        $evaluation->initiative_flexibility = $request->input('initiative_flexibility');
        $evaluation->initiative_flexibility_comment_head = $request->input('initiative_flexibility_comment_head');
        $evaluation->initiative_flexibility_comment_gm = $request->input('initiative_flexibility_comment_gm');
        $evaluation->cooperation_teamwork = $request->input('cooperation_teamwork');
        $evaluation->cooperation_teamwork_comment_head = $request->input('cooperation_teamwork_comment_head');
        $evaluation->cooperation_teamwork_comment_gm = $request->input('cooperation_teamwork_comment_gm');
        $evaluation->knowledge_of_position = $request->input('knowledge_of_position');
        $evaluation->knowledge_of_position_comment_head = $request->input('knowledge_of_position_comment_head');
        $evaluation->knowledge_of_position_comment_gm = $request->input('knowledge_of_position_comment_gm');
        $evaluation->creativity_innovation = $request->input('creativity_innovation');
        $evaluation->creativity_innovation_comment_head = $request->input('creativity_innovation_comment_head');
        $evaluation->creativity_innovation_comment_gm = $request->input('creativity_innovation_comment_gm');
        $evaluation->performance_goals = $request->input('performance_goals');
        $evaluation->over_all_rating = $request->input('over_all_rating');
        $evaluation->over_all_comment = $request->input('over_all_comment');
        $evaluation->created_by = auth()->id(); 
        $evaluation->save();
    
        return redirect()->route('annual-employee-evaluation.index')->with('success', 'Evaluation created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evaluation = AnnualEmployeeEvaluation::findOrFail($id); 

        $currentUser = auth()->user(); 
        $users = collect();
    
        if ($currentUser->team_id) {
            $users = User::where('team_id', $currentUser->team_id)->get();
        } elseif ($currentUser->department_id) {
            $users = User::where('department_id', $currentUser->department_id)
                         ->whereNull('team_id')
                         ->get();
        }
    
        return view('backend.annual_employee_evaluations.show', compact('evaluation', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $evaluation = AnnualEmployeeEvaluation::findOrFail($id); 

        $currentUser = auth()->user(); 
        $users = collect();
    
        if ($currentUser->team_id) {
            $users = User::where('team_id', $currentUser->team_id)->get();
        } elseif ($currentUser->department_id) {
            $users = User::where('department_id', $currentUser->department_id)
                         ->whereNull('team_id')
                         ->get();
        }
    
        return view('backend.annual_employee_evaluations.edit', compact('users','evaluation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $month = Carbon::now()->format('F Y'); 
        $evaluation = AnnualEmployeeEvaluation::findOrFail($id);
    
        $department = $evaluation->user->department ? $evaluation->user->department->name : 'General'; 
        $evaluationName = "Annual Evaluation - {$evaluation->user->name} - {$month} - {$department}";
    
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'nullable|string',
            'quality_of_work' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'discipline_punctuality' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'problem_solving' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'conflict_management' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'time_effectiveness_time_responsiveness_availability' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'initiative_flexibility' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'cooperation_teamwork' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'knowledge_of_position' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'creativity_innovation' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'performance_goals' => 'nullable|string',
            'over_all_rating' => 'required|in:Exceeds expectations,Meets expectations,Needs improvement,Unacceptable',
            'over_all_comment' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
    
        $evaluation->update([
            'quality_of_work' => $request->input('quality_of_work'),
            'quality_of_work_comment_head' => $request->input('quality_of_work_comment_head'),
            'quality_of_work_comment_gm' => $request->input('quality_of_work_comment_gm'),
            'discipline_punctuality' => $request->input('discipline_punctuality'),
            'discipline_punctuality_comment_head' => $request->input('discipline_punctuality_comment_head'),
            'discipline_punctuality_comment_gm' => $request->input('discipline_punctuality_comment_gm'),
            'problem_solving' => $request->input('problem_solving'),
            'problem_solving_comment_head' => $request->input('problem_solving_comment_head'),
            'problem_solving_comment_gm' => $request->input('problem_solving_comment_gm'),
            'conflict_management' => $request->input('conflict_management'),
            'conflict_management_comment_head' => $request->input('conflict_management_comment_head'),
            'conflict_management_comment_gm' => $request->input('conflict_management_comment_gm'),
            'time_effectiveness_time_responsiveness_availability' => $request->input('time_effectiveness_time_responsiveness_availability'),
            'time_effectiveness_time_responsiveness_availability_comment_head' => $request->input('time_effectiveness_time_responsiveness_availability_comment_head'),
            'time_effectiveness_time_responsiveness_availability_comment_gm' => $request->input('time_effectiveness_time_responsiveness_availability_comment_gm'),
            'initiative_flexibility' => $request->input('initiative_flexibility'),
            'initiative_flexibility_comment_head' => $request->input('initiative_flexibility_comment_head'),
            'initiative_flexibility_comment_gm' => $request->input('initiative_flexibility_comment_gm'),
            'cooperation_teamwork' => $request->input('cooperation_teamwork'),
            'cooperation_teamwork_comment_head' => $request->input('cooperation_teamwork_comment_head'),
            'cooperation_teamwork_comment_gm' => $request->input('cooperation_teamwork_comment_gm'),
            'knowledge_of_position' => $request->input('knowledge_of_position'),
            'knowledge_of_position_comment_head' => $request->input('knowledge_of_position_comment_head'),
            'knowledge_of_position_comment_gm' => $request->input('knowledge_of_position_comment_gm'),
            'creativity_innovation' => $request->input('creativity_innovation'),
            'creativity_innovation_comment_head' => $request->input('creativity_innovation_comment_head'),
            'creativity_innovation_comment_gm' => $request->input('creativity_innovation_comment_gm'),
            'performance_goals' => $request->input('performance_goals'),
            'over_all_rating' => $request->input('over_all_rating'),
            'over_all_comment' => $request->input('over_all_comment'),
            'note' => $request->input('note'),

        ]);
    
        return redirect()->route('annual-employee-evaluation.index')->with('success', 'Evaluation updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
