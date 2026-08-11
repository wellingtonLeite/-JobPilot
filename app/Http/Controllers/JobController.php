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

    public function sync(\App\Modules\Jobs\Services\JobSearchService $searchService)
    {
        $profile = \App\Models\UserProfile::where('user_id', auth()->id())->first();

        if (!$profile) {
            return back()->with('error', 'Por favor, preencha seu perfil antes de buscar vagas.');
        }

        try {
            $results = $searchService->execute($profile, ['desenvolvedor', 'php', 'laravel']);
            $count = count($results);
            return back()->with('success', "Busca concluída! $count vagas compatíveis foram encontradas e processadas pela IA.");
        } catch (\Exception $e) {
            return back()->with('error', "Erro ao buscar vagas. Certifique-se de que a Inteligência Artificial está configurada corretamente no painel de Admin. (Erro: {$e->getMessage()})");
        }
    }
}
