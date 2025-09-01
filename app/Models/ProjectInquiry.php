<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
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

      public function phases()
      {
          return $this->hasMany(ProjectInquiryPhase::class, 'project_inquiry_id');
      }
      public function department()
      {
          return $this->belongsTo(Department::class);
      }
      
      
      
      
      
      
}
