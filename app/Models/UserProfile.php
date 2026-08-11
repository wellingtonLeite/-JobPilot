<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'home_office_only',
        'english_level',
        'other_languages',
        'min_match_score',
        'resume_text',
    ];

    protected $casts = [
        'home_office_only' => 'boolean',
        'min_match_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
