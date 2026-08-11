<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $settings = \App\Models\SystemSetting::pluck('value', 'key')->toArray();
        $geminiKey = $settings['gemini_api_key'] ?? '';
        $openRouterKey = $settings['openrouter_api_key'] ?? '';
        $ollamaUrl = $settings['ollama_url'] ?? 'http://localhost:11434';

        $metrics = [
            'users' => \App\Models\User::count(),
            'jobs' => \App\Models\JobPosting::count(),
            'applications' => \App\Models\Application::count(),
        ];

        return view('admin.settings', compact('geminiKey', 'openRouterKey', 'ollamaUrl', 'metrics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gemini_api_key' => 'nullable|string',
            'openrouter_api_key' => 'nullable|string',
            'ollama_url' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\SystemSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings')->with('success', 'Configurações de IA salvas com sucesso!');
    }
}
