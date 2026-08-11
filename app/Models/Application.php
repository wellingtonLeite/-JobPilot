<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'job_posting_id', 'status', 'cover_letter', 'resume_path'
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
