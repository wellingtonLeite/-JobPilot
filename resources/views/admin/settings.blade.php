<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f0f4f8] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Configurações Globais</h1>
                <p class="text-gray-500 mt-2">Visão geral do sistema e integração das Inteligências Artificiais.</p>
            </div>

            <!-- Métricas Globais -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xl">{{ $metrics['users'] }}</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total de Usuários</p>
                        <p class="text-lg font-bold text-gray-900">Cadastrados</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 font-bold text-xl">{{ $metrics['jobs'] }}</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total de Vagas</p>
                        <p class="text-lg font-bold text-gray-900">Coletadas</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 font-bold text-xl">{{ $metrics['applications'] }}</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Candidaturas</p>
                        <p class="text-lg font-bold text-gray-900">Geradas (IA)</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-900">Sistema de Inteligência Artificial (Fallback)</h3>
                    <p class="text-gray-500 text-sm mt-1">O sistema tentará usar os provedores na ordem abaixo. Se um falhar ou ficar sem créditos, o próximo será acionado automaticamente.</p>
                </div>
                
                <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="bg-indigo-50/50 p-6 rounded-xl border border-indigo-100">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-bold">1º Prioridade</span>
                            <label class="font-bold text-gray-900">Google Gemini API Key (1.5 Flash)</label>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">Modelos gratuitos super rápidos.</p>
                        <input type="password" name="gemini_api_key" value="{{ $geminiKey }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white" placeholder="AIzaSyA...">
                    </div>

                    <div class="bg-purple-50/50 p-6 rounded-xl border border-purple-100">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-bold">2º Prioridade</span>
                            <label class="font-bold text-gray-900">OpenRouter API Key</label>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">Acesso a modelos gratuitos como Meta Llama 3 8B, Google Gemma, etc.</p>
                        <input type="password" name="openrouter_api_key" value="{{ $openRouterKey }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white" placeholder="sk-or-v1-...">
                    </div>

                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-slate-200 text-slate-700 rounded text-xs font-bold">3º Prioridade</span>
                            <label class="font-bold text-gray-900">Ollama API (Cloud ou Local)</label>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">Se for usar localmente deixe o URL padrão e a API Key em branco. Se for usar o Ollama Cloud, coloque o URL da nuvem e a chave gerada lá.</p>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Ollama URL</label>
                                <input type="text" name="ollama_url" value="{{ $ollamaUrl }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 bg-white" placeholder="https://api.ollama.com">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Ollama API Key</label>
                                <input type="password" name="ollama_api_key" value="{{ $ollamaApiKey }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 bg-white" placeholder="Sua chave API do Ollama (Opcional)">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition">
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
