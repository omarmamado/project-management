<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. إنشاء الشركة
        $company = Company::create([
            'name' => 'polygon technology', // اسم الشركة
        ]);

        // 2. إنشاء القسم
        $department = Department::create([
            'name' => 'nanotrition', // اسم القسم
            'company_id' => $company->id, // ربط القسم بالشركة
            // أي تفاصيل أخرى متعلقة بالقسم
        ]);

        // 3. إنشاء مدير عام (GM)
        User::create([
            'name' => 'admin ',
            'email' => 'admin@app.com',
            'password' => Hash::make('12345678'), // كلمة مرور مشفرة
            'company_id' => $company->id, // ربط بالشركة
            'department_id' => $department->id, // ربط بالقسم
            'role' => 'gm', // تحديد دوره كـ GM
            'is_manager' => true, // تحديد أنه مدير
        ]);
    }
}
