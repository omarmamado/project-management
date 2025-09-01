<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CashRequest extends Model
{
    // protected $fillable = [
    //     'request_name',
    //     'reason',
    //     'request_date',
    //     'due_date',
    //     'amount',
    //     'user_id',
    //     'cash_category_id',
    //     'status',
    //     'approved_by_manager',
    //     'approved_by_accounts',
    //     'approved_by_gm',
    //     'attachment',
    //     'phase_id',
    //     'project_inquiries_id',
    //     'project_id',
    // ];
    protected $fillable = [
        'request_name', 'reason', 'request_date', 'due_date',
        'cash_category_id', 'amount', 'user_id', 'status',
        'approved_by_manager', 'approved_by_accounts',
        'approved_by_gm', 'attachment', 'phase_id',
        'project_inquiries_id', 'task_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by_manager');
    }

    public function accounts()
    {
        return $this->belongsTo(User::class, 'approved_by_accounts');
    }

    public function gm()
    {
        return $this->belongsTo(User::class, 'approved_by_gm');
    }
    public function cashRequestItem()
    {
        return $this->hasMany(cashRequestItem::class);
    }

public function cashCategory()
{
    return $this->belongsTo(CashCategory::class, 'cash_category_id');
}
}

