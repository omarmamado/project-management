<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    protected $fillable = [
        'idea_roadmap_id',
        'title',
        'description',
       
        'created_by',
    ];
    public function ideaRoadmap()
    {
        return $this->belongsTo(IdeaRoadmap::class);
    }
    public function images()
{
    return $this->hasMany(IdeaImage::class);
}
public function roadmap()
{
    return $this->belongsTo(IdeaRoadmap::class, 'idea_roadmap_id');
}
public function votes()
{
    return $this->hasMany(IdeaVote::class);
}

public function getUpvotesAttribute()
{
    return $this->votes()->where('vote', 'up')->count();
}

public function getDownvotesAttribute()
{
    return $this->votes()->where('vote', 'down')->count();
}
public function comments()
{
    return $this->hasMany(IdeaComment::class)->whereNull('parent_id')->latest();
}

    
}
