<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'idea_id',
        'image_path',
    ];
    public function idea()
{
    return $this->belongsTo(Idea::class);
}
}
