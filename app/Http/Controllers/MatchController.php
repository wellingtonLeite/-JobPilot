<?php

namespace App\Http\Controllers;

use App\Models\JobMatch;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = JobMatch::with('jobPosting')
            ->where('user_id', auth()->id())
            ->orderBy('score', 'desc')
            ->paginate(12);

        return view('matches.index', compact('matches'));
    }
}
