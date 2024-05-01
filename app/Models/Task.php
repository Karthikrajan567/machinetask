<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'task_description',
        'task_end_date',
        'task_member',
        'task_status',
        'uuid',
        'company_id'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'task_member', 'uuid');
    }
}
