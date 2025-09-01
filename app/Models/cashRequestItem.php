<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cashRequestItem extends Model
{
    use HasFactory;
    protected $fillable = ['cash_request_id', 'item_name', 'price'];

    // علاقة مع طلب المصروف
    public function cashRequest()
    {
        return $this->belongsTo(CashRequest::class);
    }
}
