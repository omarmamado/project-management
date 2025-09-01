<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaseTag extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function phase()
{
    return $this->belongsTo(ProjectInquiryPhase::class, 'phase_id');
}

}
