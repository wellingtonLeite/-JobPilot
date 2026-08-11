<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'job_source_id', 'external_id', 'title', 'company', 
        'description', 'requirements', 'city', 'state', 'country', 
        'work_mode', 'employment_type', 'application_status', 
        'application_url', 'source_url', 'published_at'
    ];
    
    protected $casts = [
        'requirements' => 'array',
        'published_at' => 'datetime',
    ];
}
