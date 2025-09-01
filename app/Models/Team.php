<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class); // علاقة كثير إلى 1 مع القسم
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    
}
