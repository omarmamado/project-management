<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name', 'email', 'phone', 'password', 'company_id', 'department_id', 'role', 'is_manager'
    // ];
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function team()
{
    return $this->belongsTo(Team::class, 'team_id');

}

    // علاقة الموظف بالعقود
    public function employmentcontracts()
    {
        return $this->hasMany(EmploymentContract::class);
    }
    public function EmployeeTraining()
    {
        return $this->hasOne(EmployeeTraining::class, 'user_id');
    }
    public function employmentcontract()
{
    return $this->hasOne(EmploymentContract::class);
}
public function evaluations()
{
    return $this->hasMany(EmployeeEvaluation::class);
}
public function accounts()
{
    return $this->hasMany(UserAccount::class);
}
public function tasksCreated()
{
    return $this->hasMany(Task::class, 'created_by');
}

public function assignedTasks()
{
    return $this->belongsToMany(Task::class, 'task_user');
}
public function projects()
{
    return $this->belongsToMany(Project::class, 'project_user'); 
}
public function createdProjects()
{
    return $this->hasMany(ProjectInquire::class, 'creator_id');
}
public function teams()
{
    return $this->hasMany(Team::class);
}
public function managedProjects()
{
    return $this->hasMany(Project::class, 'manager_id');
}
public function tasks()
{
    return $this->belongsToMany(Task::class, 'task_user', 'user_id', 'task_id');
}
public function phases()
{
    return $this->belongsToMany(ProjectInquiryPhase::class, 'phase_user', 'user_id', 'phase_id');
}




}
