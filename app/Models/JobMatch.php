<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobMatch extends Model
{
    protected $fillable = [
        'user_id', 'job_posting_id', 'score', 'match_details', 'status'
    ];

    protected $casts = [
        'match_details' => 'array',
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
