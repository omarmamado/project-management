<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
    public function projectInquiries()
{
    return $this->hasMany(ProjectInquiry::class);
}


}

