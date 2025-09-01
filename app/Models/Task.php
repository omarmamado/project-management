<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function phase()
    {
        return $this->belongsTo(ProjectInquiryPhase::class, 'phase_id');
    }
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

}