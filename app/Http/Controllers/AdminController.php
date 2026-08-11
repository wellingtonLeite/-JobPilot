<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $geminiKey = \App\Models\SystemSetting::where('key', 'gemini_api_key')->value('value');
        return view('admin.settings', compact('geminiKey'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gemini_api_key' => 'required|string',
        ]);

        \App\Models\SystemSetting::updateOrCreate(
            ['key' => 'gemini_api_key'],
            ['value' => $validated['gemini_api_key']]
        );

        return redirect()->route('admin.settings')->with('success', 'Chave de API salva com sucesso!');
    }
}
