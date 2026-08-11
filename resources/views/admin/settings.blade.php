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
                <p class="text-gray-500 mt-2">Gerencie as chaves de integração das Inteligências Artificiais e Scraping.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Integrações de Inteligência Artificial</h3>
                
                <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">Google Gemini API Key (1.5 Flash)</label>
                        <p class="text-sm text-gray-500 mb-2">Essa chave será usada pelo Orquestrador para ler os currículos e calcular o match com as vagas.</p>
                        <input type="password" name="gemini_api_key" value="{{ $geminiKey }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="AIzaSyA...">
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
