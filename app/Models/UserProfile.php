<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'home_office_only',
        'has_english_proficiency',
        'min_match_score',
        'resume_text',
    ];

    protected $casts = [
        'home_office_only' => 'boolean',
        'has_english_proficiency' => 'boolean',
        'min_match_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
