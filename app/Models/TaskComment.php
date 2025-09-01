<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskComment extends Model
{
        use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'comment', 'parent_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(TaskComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(TaskComment::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(TaskCommentFile::class);
    }
}