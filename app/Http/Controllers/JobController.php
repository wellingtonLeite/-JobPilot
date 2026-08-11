<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');
        }

        if ($request->has('work_mode') && !empty($request->work_mode)) {
            $query->where('work_mode', $request->work_mode);
        }

        $jobs = $query->orderBy('posted_at', 'desc')->paginate(12);

        return view('jobs.index', compact('jobs'));
    }
}
