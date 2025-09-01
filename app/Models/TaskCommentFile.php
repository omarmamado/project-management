<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskCommentFile extends Model
{
    use HasFactory;

    protected $fillable = ['task_comment_id', 'file_path', 'file_type'];

    public function comment()
    {
        return $this->belongsTo(TaskComment::class, 'task_comment_id');
    }
}