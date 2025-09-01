<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInquiryPhase extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
    public function tags()
{
    return $this->hasMany(PhaseTag::class, 'phase_id');
}
// public function projectInquiry()
// {
//     return $this->belongsTo(ProjectInquiry::class);
// }
public function teamMembers()
{
    return $this->belongsToMany(User::class, 'phase_user', 'phase_id', 'user_id');
}
public function users()
{
    return $this->belongsToMany(User::class, 'phase_user', 'phase_id', 'user_id');
}
public function projectInquiry()
{
    return $this->belongsTo(ProjectInquiry::class, 'project_inquiries_id');
}
public function tasks()
{
    return $this->hasMany(Task::class, 'phase_id');
}


  
}
