<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmployeeTraining;
use App\Models\EmploymentContract;
use App\Models\EmployementDocument;
use App\Http\Controllers\Controller;
use App\Models\EmploymentAllowances;
use Illuminate\Support\Facades\Date;

class EmployeeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function index()
    // {
    //     // جلب جميع المستخدمين مع العقود والمستندات الخاصة بالتعيين مرتبة من الأحدث إلى الأقدم
    //     $users = User::with(['employmentDocuments', 'employmentcontracts' => function ($query) {
    //         $query->orderBy('created_at', 'desc'); // ترتيب العقود من الأحدث إلى الأقدم
    //     }])->get();

    //     // تنبيهات انتهاء فترة التدريب (قبل انتهاء الفترة بـ 10 أيام)
    //     $trainingAlerts = EmploymentContract::whereDate('end_date', '<=', now()->addDays(10))
    //         ->where('is_renewed', false)
    //         ->orderBy('created_at', 'desc') // ترتيب التنبيهات حسب تاريخ الإضافة
    //         ->get();

    //     // تنبيهات انتهاء العقد (قبل انتهاء العقد بـ 10 أيام)
    //     $contractAlerts = EmploymentContract::whereDate('end_date', '<=', now()->addDays(10))
    //         ->where('is_renewed', false)
    //         ->orderBy('created_at', 'desc') // ترتيب التنبيهات حسب تاريخ الإضافة
    //         ->get();

    //     return view('pages.employee-profile.index', compact('users', 'trainingAlerts', 'contractAlerts'));
    // }

    public function index()
    {
        // Fetch employees who have at least one associated file or data in related tables, ordered by latest entries
        $employees = User::with(['EmployeeTraining', 'employmentcontracts', 'employmentDocuments'])
            ->whereHas('EmployeeTraining')
            ->orWhereHas('employmentcontracts')
            ->orWhereHas('employmentDocuments', function ($query) {
                $query->whereNotNull('id_card')
                    ->orWhereNotNull('birth_certificate')
                    ->orWhereNotNull('graduation_certificate')
                    ->orWhereNotNull('criminal_record')
                    ->orWhereNotNull('military_certificate');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.employee-profile.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all(); // جلب جميع الموظفين
        $contracts = EmploymentContract::with('user')->get(); // جلب العقود
        return view('pages.employee-profile.create', compact('users', 'contracts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
        // dd($request->all());

            // تحقق من صحة البيانات
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'training_start_date' => 'nullable|date',
                'training_end_date' => 'nullable|date',
                'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'contract_start_date' => 'nullable|date',
                'contract_end_date' => 'nullable|date',
                'id_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'graduation_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'criminal_record' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'military_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'salary' => 'nullable',
                'allowance_type' => 'nullable|array', // يجب أن تكون مصفوفة
                'amount' => 'nullable|array', // يجب أن تكون مصفوفة
            ]);

            // إضافة فترة التدريب
            if ($request->filled(['training_start_date', 'training_end_date'])) {
                EmployeeTraining::create([
                    'user_id' => $request->user_id,
                    'training_start_date' => $request->training_start_date,
                    'training_end_date' => $request->training_end_date,
                ]);
            }

            // إضافة العقد
            $contractData = [
                'user_id' => $request->user_id,
                'start_date' => $request->contract_start_date,
                'end_date' => $request->contract_end_date,
                'is_renewed' => $request->has('is_renewed'),
                'salary' => $request->salary,
            ];

            if ($request->hasFile('contract_file')) {
                $contractFilename = 'contract_' . time() . '.' . $request->file('contract_file')->getClientOriginalExtension();
                $request->file('contract_file')->move(public_path('documents'), $contractFilename);
                $contractData['contract_file'] = 'documents/' . $contractFilename;
            }

            $contract = EmploymentContract::create($contractData);

            // إضافة البدلات المرتبطة بالعقد
            if ($request->has('allowance_type') && $request->has('amount')) {
                foreach ($request->allowance_type as $index => $type) {
                    if (!empty($type) && isset($request->amount[$index])) {
                        EmploymentAllowances::create([
                            'employment_contract_id' => $contract->id, // استخدام ID العقد الذي تم إنشاؤه
                            'allowance_type' => $type,
                            'amount' => $request->amount[$index],
                        ]);
                    }
                }
            }

            // إضافة الوثائق
            $documentData = [
                'user_id' => $request->user_id,
            ];

            foreach (['id_card', 'birth_certificate', 'graduation_certificate', 'criminal_record', 'military_certificate'] as $field) {
                if ($request->hasFile($field)) {
                    $filename = $field . '_' . time() . '.' . $request->file($field)->getClientOriginalExtension();
                    $request->file($field)->move(public_path('documents'), $filename);
                    $documentData[$field] = 'documents/' . $filename;
                }
            }

            EmployementDocument::create($documentData);

        } catch (\Exception $e) {
            dd($e->getMessage(),);
        }

        return redirect()->back()->with('success', 'Employee profile data saved successfully.');
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
    public function edit($id)
    {
        // جلب الموظف بناءً على الـ ID مع تفاصيل العقود، الوثائق، وفترة التدريب
        $employee = User::with(['EmployeeTraining', 'employmentcontracts.allowances', 'employmentDocuments'])
            ->findOrFail($id); // إذا لم يتم العثور على المستخدم، سيتم إرجاع خطأ 404

        // جلب جميع الموظفين لاستخدامهم في القائمة المنسدلة (إن كنت بحاجة إليهم في نموذج التعديل)
        $users = User::all();

        // جلب العقود لعرضها أو استخدامها حسب الحاجة
        $contracts = EmploymentContract::with('user')->get();


        return view('pages.employee-profile.edit', compact('employee', 'users', 'contracts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'training_start_date' => 'nullable|date',
            'training_end_date' => 'nullable|date',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'id_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'graduation_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'criminal_record' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'military_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'salary' => 'nullable',
            'allowance_type' => 'nullable|array',
            'amount' => 'nullable|array',
        ]);
    
        $employee = User::findOrFail($id);
    
        // تحديث العقد أو إنشاؤه إذا لم يكن موجودًا
        $contractData = [
            'user_id' => $request->user_id,
            'start_date' => $request->contract_start_date,
            'end_date' => $request->contract_end_date,
            'salary' => $request->salary,
            'is_renewed' => $request->has('is_renewed'),
        ];
    
        if ($request->hasFile('contract_file')) {
            $contractFilename = 'contract_' . time() . '.' . $request->file('contract_file')->getClientOriginalExtension();
            $request->file('contract_file')->move(public_path('documents'), $contractFilename);
            $contractData['contract_file'] = 'documents/' . $contractFilename;
        }
    
        $contract = EmploymentContract::updateOrCreate(
            ['user_id' => $id],
            $contractData
        );
    
        if ($contract && $request->has('allowances')) {
            foreach ($request->allowances as $contractIndex => $allowances) {
                // حذف البدلات القديمة لهذا العقد
                $contract->allowances()->delete();
    
                // إضافة البدلات المحدثة
                foreach ($allowances as $allowance) {
                    if (!empty($allowance['type']) && isset($allowance['amount'])) {
                        EmploymentAllowances::create([
                            'employment_contract_id' => $contract->id,
                            'allowance_type' => $allowance['type'],
                            'amount' => $allowance['amount'],
                        ]);
                    }
                }
            }
        }
    
        return redirect()->back()->with('success', 'Employee profile updated successfully.');
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

   // app/Http/Controllers/ExpiringController.php
// public function alert()
// {
//     $expiringTrainings = EmployeeTraining::where('training_end_date', '<=', Date::now()->addDays(10))->get();
//     $expiringContracts = EmploymentContract::where('end_date', '<=', Date::now()->addDays(10))->get();
//     return view('pages.employee-profile.alert', compact('expiringTrainings', 'expiringContracts'));
// }
// public function alert()
// {
//     // البحث عن التدريبات التي تنتهي قريباً والتي لا توجد لديها عقود بعد
//     $expiringTrainings = EmployeeTraining::where('training_end_date', '<=', now()->addDays(10))
//         ->whereDoesntHave('employmentContract') // التأكد من عدم وجود عقد للموظف
//         ->get();

//     // البحث عن العقود التي تنتهي قريباً
//     $expiringContracts = EmploymentContract::where('end_date', '<=', now()->addDays(10))->get();

//     return view('pages.employee-profile.alert', compact('expiringTrainings', 'expiringContracts'));
// }

public function alert()
{
    // البحث عن التدريبات التي تنتهي قريباً والتي لا يوجد لديها عقود حديثة
    $expiringTrainings = EmployeeTraining::where('training_end_date', '<=', now()->addDays(10))
        ->whereDoesntHave('employmentContract', function ($query) {
            $query->where('end_date', '>', now());
        })
        ->get();

    // جلب آخر عقد لكل مستخدم بناءً على `end_date` للتحقق من انتهائه قريباً
    $expiringContracts = EmploymentContract::select('user_id', 'end_date')
        ->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('employment_contracts')
                ->groupBy('user_id'); // جلب آخر عقد لكل مستخدم
        })
        ->where('end_date', '<=', now()->addDays(10)) // فقط العقود التي تنتهي قريباً
        ->get();

    return view('pages.employee-profile.alert', compact('expiringTrainings', 'expiringContracts'));
}

public function addEmploymentContrac(Request $request)
{
    try {
        // dd($request->all());
        // التحقق من صحة البيانات
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'contract_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'salary' => 'nullable|numeric',
        ]);

        // تجهيز بيانات العقد
        $contractData = [
            'user_id' => $request->user_id,
            'start_date' => $request->contract_start_date,
            'end_date' => $request->contract_end_date,
            'salary' => $request->salary,
        ];

        // رفع ملف العقد إذا كان موجودًا
        if ($request->hasFile('contract_file')) {
            $contractFilename = 'contract_' . time() . '.' . $request->file('contract_file')->getClientOriginalExtension();
            $request->file('contract_file')->move(public_path('documents'), $contractFilename);
            $contractData['contract_file'] = 'documents/' . $contractFilename;
        }

        // إضافة العقد في قاعدة البيانات
        EmploymentContract::create($contractData);

        return redirect()->back()->with('success', 'Contract added successfully.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
    }
}

}
