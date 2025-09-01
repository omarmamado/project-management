<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function phases()
    {
        return $this->hasMany(ProjectInquiryPhase::class, 'project_inquiries_id');
    }
    public function ideaRoadmaps()
    {
        return $this->hasMany(IdeaRoadmap::class);
    }

}