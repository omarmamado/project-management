<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaComment extends Model
{
    use HasFactory;
    protected $fillable = ['idea_id', 'user_id', 'comment', 'parent_id'];



// Comment.php
public function idea() {
    return $this->belongsTo(Idea::class);
}

public function user() {
    return $this->belongsTo(User::class);
}

public function replies() {
    return $this->hasMany(related: IdeaComment::class, foreignKey: 'parent_id');
}


}
