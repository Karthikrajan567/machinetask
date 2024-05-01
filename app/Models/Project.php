<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_name',
        'project_description',
        'project_start_date',
        'project_end_date',
        'project_manager',
        'project_member',
        'uuid',
        'company_id'
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'project_manager', 'uuid');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'project_member', 'uuid');
    }
}
