<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'         => $row['name'],
            'phone'        => $row['phone'] ?? null, 
            'photo'        => $row['photo'] ?? null, 
            'email'        => $row['email'],
            'job_title'        => $row['job_title'] ?? null,
            'password'     => Hash::make('123456'), 
            'company_id'   => $row['company_id'] ?? null, 
            'department_id'=> $row['department_id'] ?? null, 
            'role'         => 'employee', 
            'is_manager'   => false, 
        ]);
    }
    
}
