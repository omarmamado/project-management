<?php

namespace App\Http\Controllers\Project;

use auth;
use App\Models\Task;
use App\Models\Project;
use App\Models\CashRequest;
use App\Models\CashCategory;
use Illuminate\Http\Request;
use App\Models\ProjectInquiry;
use App\Models\ProjectInquiryPhase;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
public function index() {  
    $cash_categories = CashCategory::all();
   
    $user = auth()->user();      

    if (in_array($user->role, ['hr', 'gm'])) {
        $projectInquiries = ProjectInquiry::whereHas('phases', function($query) {
            $query->where('status', 'approved')
                  ->whereHas('users');
        })->with([
            'phases' => function ($query) {
                $query->where('status', 'approved')
                      ->whereHas('users');
            }, 
            'phases.tasks', 
            'phases.users'
        ])->get();
    } else {
        $projectInquiries = ProjectInquiry::where(function($query) use ($user) {
            $query->where('manager_id', $user->id)
                  ->orWhere('creator_id', $user->id)
                  ->orWhereHas('phases.users', function($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        })
        ->whereHas('phases', function($query) {
            $query->where('status', 'approved')
                  ->whereHas('users');
        })
        ->with([
            'phases' => function ($query) {
                $query->where('status', 'approved')
                      ->whereHas('users');
            }, 
            'phases.tasks', 
            'phases.users'
        ])
        ->get();
    }      

    return view('backend.task.index', compact('projectInquiries','cash_categories')); 
}
    

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

   
    public function store(Request $request)
{
    // dd($request->all());
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'note' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'phase_id' => 'required|exists:project_inquiry_phases,id',
        'project_inquiries_id' => 'required|exists:project_inquiries,id',
        'priority' => 'required|in:high,medium,low',
        'user_ids' => 'required|array', // استقبال المستخدمين كمصفوفة
        'user_ids.*' => 'exists:users,id', // التأكد من أن كل مستخدم موجود في قاعدة البيانات
    ]);

    try {
        $task = Task::create([
            'name' => $validatedData['name'],
            'note' => $validatedData['note'] ?? null,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'phase_id' => $validatedData['phase_id'],
            'project_inquiries_id' => $validatedData['project_inquiries_id'],
            'priority' => $validatedData['priority'],
            'status' => 'pending',
            'approved_by_manager' => null,
            'created_by' => auth()->id(),
        ]);

        // ربط المهمة بالمستخدمين المختارين
        $task->users()->attach($validatedData['user_ids']);

        return redirect()->back()->with('success', 'Task created successfully');
    } catch (\Exception $e) {
        \Log::error('خطأ في إضافة مهمة: ' . $e->getMessage());

        return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المهمة: ' . $e->getMessage());
    }
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'phase_id' => 'required|exists:project_inquiry_phases,id',
            'project_inquiries_id' => 'required|exists:project_inquiries,id',
            'priority' => 'required|in:high,medium,low',
            'user_ids' => 'nullable|array', // تأكد من استلام المستخدمين كـ مصفوفة
            'user_ids.*' => 'exists:users,id' // تأكد من أن كل معرف مستخدم موجود
        ]);
    
        try {
            // Find the task by ID
            $task = Task::find((int) $id);
    
            // Check if the task exists
            if (!$task) {
                return redirect()->back()->with('error', 'Task not found in the database.');
            }
    
            // Update task attributes and save
            $task->name = $validatedData['name'];
            $task->note = $validatedData['note'] ?? null;
            $task->start_date = $validatedData['start_date'];
            $task->end_date = $validatedData['end_date'];
            $task->phase_id = $validatedData['phase_id'];
            $task->project_inquiries_id = $validatedData['project_inquiries_id'];
            $task->priority = $validatedData['priority'];
    
            $task->save();
    
            // Update assigned users
            if ($request->has('user_ids')) {
                $task->users()->sync($validatedData['user_ids']);
            } else {
                $task->users()->sync([]); // إذا لم يتم إرسال أي مستخدمين، يتم إفراغ القائمة
            }
    
            return redirect()->back()->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating task: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the task: ' . $e->getMessage());
        }
    }
    public function cashRequest(Request $request)
    {
        // التحقق من صحة المدخلات
        $validated = $request->validate([
            'request_name' => 'required|string',
            'reason' => 'required|string',
            'request_date' => 'required|date',
            'cash_category_id' => 'required',
            'due_date' => 'required|date|after_or_equal:request_date', // تحقق من أن due_date ليس قبل request_date
            'amount' => 'required|numeric',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png',
            'items.*' => 'required|string',
            'prices.*' => 'required|numeric',
            'phase_id' => 'required|exists:project_inquiry_phases,id',
            'project_inquiries_id' => 'required|exists:project_inquiries,id',
        ]);
        // dd($validated);

        // معالجة الملف إذا تم تحميله
        $attachment = null;
        if ($request->hasFile('attachment')) {
            // الحصول على اسم الملف الأصلي
            $originalFilename = $request->file('attachment')->getClientOriginalName();

            // الحصول على اسم الطلب وتنسيق التاريخ الحالي
            $requestName = $request->request_name;
            $currentDate = Carbon::now()->format('Y-m-d');

            // الحصول على اسم الشخص (المستخدم الحالي)
            $userName = auth()->user()->name; // أو auth()->user()->username إذا كنت تستخدم username

            // إنشاء اسم جديد للملف يشمل اسم الطلب، اسم الشخص، والتاريخ
            $newFilename = $userName . '_' . $requestName . '_' . $currentDate . '_' . $originalFilename;
            
            $attachment = $request->file('attachment')->move(public_path("attachments"), $newFilename);

        }
        $status = 'pending';
        $approvedByManager = null;
        $approvedByAccounts = null;
        $approvedByGm = null;

        if (auth()->user()->is_manager) {
            if (auth()->user()->role === 'gm') {
                // إذا كان المدير العام، يتم تعيين الموافقة تلقائيًا للمدير العام
                $status = 'approved_by_gm';
                $approvedByGm = auth()->id();
            } elseif (auth()->user()->role === 'accounts') {
                // إذا كان مدير الحسابات، يتم تعيين الموافقة للحسابات
                $status = 'approved_by_accounts';
                $approvedByAccounts = auth()->id();
            } else {
                // إذا كان مديرًا ولكن ليس في الحسابات أو المدير العام، يتم تعيين الموافقة للمدير فقط
                $status = 'approved_by_manager';
                $approvedByManager = auth()->id();
            }
        }
        // إنشاء طلب المصروف
        $cashRequest = CashRequest::create([
            'request_name' => $request->request_name,
            'reason' => $request->reason,
            'request_date' => $request->request_date,
            'due_date' => $request->due_date,
            'cash_category_id' => $request->cash_category_id,
            'amount' => $request->amount,
            'user_id' => auth()->id(),
            'status' => $status,
            'phase_id' => $request['phase_id'],
            'project_inquiries_id' => $request['project_inquiries_id'],
            'approved_by_manager' => $approvedByManager,
            'approved_by_accounts' => $approvedByAccounts,
            'approved_by_gm' => $approvedByGm,
            'attachment' => $attachment,
        ]);

        // إضافة العناصر والأسعار
        foreach ($request->item_name as $index => $item) {
            if (!empty($item) && isset($request->price[$index])) {
                cashRequestItem::create([
                    'cash_request_id' => $cashRequest->id,
                    'item_name' => $item,
                    'price' => $request->price[$index], // تأكد أن الحقل price[] في الطلب
                ]);
            }
        }
    
        return redirect()->route('task.index')->with('success', 'Cash request created successfully');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
