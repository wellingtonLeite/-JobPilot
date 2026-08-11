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
            'has_english_proficiency' => 'required|boolean',
            'min_match_score' => 'required|integer|min:0|max:100',
        ]);

        $profile = new \App\Models\UserProfile($validated);
        auth()->user()->profile()->save($profile);

        return redirect()->route('dashboard')->with('success', 'Perfil configurado com sucesso!');
    }
}
