<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\UserCompany;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Mail\PasswordSetupEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index()
{
    $users = User::orderBy('id','desc')->latest()->get();
    $companies = Company::all();
    $teams = Team::all();
    $departments = Department::all();
    return view( 'backend.users.index', compact('companies', 'departments','users','teams'));
}


public function edit($id)
{
}


public function store(Request $request)
{
    try {
    // التحقق من البيانات المدخلة
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'job_title' => 'string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'company_id' => 'nullable|exists:companies,id',
        'department_id' => 'nullable|exists:departments,id',
        'role' => 'required|in:employee,hr,accounts,gm',
        'is_manager' => 'boolean',
        'team_id'=> 'nullable|exists:teams,id',
    ]);
    // dd($validatedData);

        // كلمة المرور الثابتة
        $password = '123456';
        // إنشاء المستخدم
        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'job_title' => $validatedData['job_title'],
            'company_id' => $validatedData['company_id'],
            'department_id' => $validatedData['department_id'],
            'team_id' => $validatedData['team_id'],
            'role' => $validatedData['role'],
            'is_manager' => $validatedData['is_manager'] ?? false,
            'password' => Hash::make($password), // تعيين كلمة المرور
        ]);
        // dd($user);


        // إرسال البريد الإلكتروني مع الرابط وكلمة المرور
        $loginLink = route('login'); // رابط تسجيل الدخول

        Mail::to($user->email)->send(new PasswordSetupEmail($user, $password, $loginLink));

        $notification = array(
            'message' => 'User added successfully',
            'alert-type' => 'success'
        );
    } catch (\Exception $e) {
        dd($e->getMessage());
        // في حال حدوث خطأ
        return back()->withErrors(['error' => 'There was an issue adding the user. ' . $e->getMessage()]);
    }

    return back()->with($notification);
}

// public function update(Request $request, $id)
// {
//     // Validate the input data
//     $validatedData = $request->validate([
//         'name' => 'required|string|max:255',
//         'phone' => 'required|string|max:255',
//         'job_title' => 'string|max:255',
//         'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Exclude current email
//         'company_id' => 'nullable|exists:companies,id',
//         'department_id' => 'nullable|exists:departments,id',
//         'role' => 'required|in:employee,hr,accounts,gm',
//         'is_manager' => 'boolean',
//     ]);

//     try {
//         // Fetch the existing user by ID
//         $user = User::findOrFail($id);

//         // Store the user details before deleting
//         $userData = [
//             'id' => $id, // Retain the same ID
//             'name' => $validatedData['name'],
//             'phone' => $validatedData['phone'],
//             'email' => $validatedData['email'],
//             'job_title' => $validatedData['job_title'],
//             'company_id' => $validatedData['company_id'],
//             'department_id' => $validatedData['department_id'],
//             'role' => $validatedData['role'],
//             'is_manager' => $validatedData['is_manager'] ?? false,
//         ];

//         // Delete the user (if you need to, although not typical for updates)
//         $user->delete();

//         // Create a new user with the same ID
//         User::create($userData);

//         // Confirmation message
//         $notification = array(
//             'message' => 'User updated successfully',
//             'alert-type' => 'success'
//         );
//     } catch (\Exception $e) {
//         // Handle any errors
//         return back()->withErrors(['error' => 'There was an issue updating the user. ' . $e->getMessage()]);
//     }

//     return back()->with($notification);
// }
public function update(Request $request, $id)
{
    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // التحقق من أن البريد الإلكتروني فريد باستثناء المستخدم الحالي
        'phone' => 'nullable|string|max:255',
        'company_id' => 'nullable|exists:companies,id',
        'department_id' => 'nullable|exists:departments,id',
        'team_id'=> 'nullable|exists:teams,id',
        'job_title' => 'nullable|string|max:255',
        'role' => 'required|in:employee,hr,accounts,gm',
        'is_manager' => 'nullable|boolean',
    ]);

    // البحث عن المستخدم عن طريق ID
    $user = User::findOrFail($id);

    // تحديث البيانات
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->company_id = $request->input('company_id');
    $user->department_id = $request->input('department_id');
    $user->team_id = $request->input('team_id');
    $user->job_title = $request->input('job_title');
    $user->role = $request->input('role');
    $user->is_manager = $request->input('is_manager', 0); // إذا لم يتم التحقق من "Is Manager"، سيكون القيمة الافتراضية 0

    // حفظ التعديلات في قاعدة البيانات
    $user->save();
    $notification = array(
        'message' => 'User added successfully',
        'alert-type' => 'success'
    );

    // إعادة التوجيه أو الرد بعد الحفظ
    return back()->with($notification);
}



public function getDepartmentsByCompany(Request $request)
{
    $companyId = $request->input('company_id');
    $departments = Department::where('company_id', $companyId)->get(['id', 'name']);
    return response()->json($departments);
}

public function export()
    {
        dd('Export function called');

        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        // dd($request->all());

        // استيراد البيانات من الملف
        Excel::import(new UsersImport, $request->file('file'));

        // رسالة نجاح
        return redirect()->back()->with('success', 'تم استيراد المستخدمين بنجاح.');
    }
    public function getTeams($departmentId)
    {
        $teams = Team::where('department_id', $departmentId)->get();
        return response()->json($teams);
    }
//     public function getTeams($departmentId)
// {
//     try {
//         $teams = Team::where('department_id', $departmentId)->get();
//         \Log::info('Teams retrieved:', ['count' => $teams->count(), 'teams' => $teams]);
//         return response()->json($teams);
//     } catch (\Exception $e) {
//         \Log::error('Error retrieving teams:', ['error' => $e->getMessage()]);
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }





}
