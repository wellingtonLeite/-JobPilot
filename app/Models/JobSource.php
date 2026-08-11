<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSource extends Model
{
    protected $fillable = ['name', 'slug', 'enabled'];
}
