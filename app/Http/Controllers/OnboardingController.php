<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        // Se o usuário já tem perfil, redireciona para o dashboard
        if (auth()->user()->profile) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_office_only' => 'required|boolean',
            'english_level' => 'required|string',
            'other_languages' => 'nullable|string|max:255',
            'min_match_score' => 'required|integer|min:0|max:100',
            'resume_text' => 'nullable|string',
            'resume_pdf' => 'nullable|mimes:pdf|max:10240', // até 10MB
        ]);

        $resumeText = $validated['resume_text'] ?? '';

        if ($request->hasFile('resume_pdf')) {
            $pdfParser = new \Smalot\PdfParser\Parser();
            $pdf = $pdfParser->parseFile($request->file('resume_pdf')->getPathname());
            $resumeText = $pdf->getText();
        }

        $request->user()->profile()->create([
            'home_office_only' => $validated['home_office_only'],
            'english_level' => $validated['english_level'],
            'other_languages' => $validated['other_languages'] ?? null,
            'min_match_score' => $validated['min_match_score'],
            'resume_text' => $resumeText,
        ]);

        return redirect()->route('dashboard')->with('success', 'Perfil configurado com sucesso!');
    }
}
