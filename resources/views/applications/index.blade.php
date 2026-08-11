<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Candidaturas (IA)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f0f4f8] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Rascunhos Gerados</h1>
                <p class="text-gray-500 mt-2">Vagas com altíssimo nível de compatibilidade onde a IA já preparou seu texto de abordagem.</p>
            </div>

            <div class="space-y-6">
                @forelse($applications as $app)
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 transition hover:shadow-md">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $app->jobPosting->title }}</h3>
                            <p class="text-gray-500">{{ $app->jobPosting->company }} • {{ ucfirst($app->jobPosting->work_mode) }}</p>
                        </div>
                        <a href="{{ $app->jobPosting->source_url }}" target="_blank" class="px-6 py-2 bg-indigo-50 text-indigo-700 font-bold rounded-xl hover:bg-indigo-100 transition">
                            Ver Vaga Original
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 relative group">
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                            <button onclick="navigator.clipboard.writeText(this.nextElementSibling.innerText); alert('Copiado!')" class="px-3 py-1 bg-white text-gray-600 rounded shadow-sm text-xs font-bold border border-gray-200 hover:text-indigo-600">
                                Copiar Texto
                            </button>
                            <div class="hidden">{{ $app->cover_letter }}</div>
                        </div>
                        <h4 class="text-sm font-bold text-gray-500 mb-3 uppercase tracking-wider">Draft: Cover Letter / Abordagem</h4>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $app->cover_letter }}</p>
                    </div>
                    
                    <div class="mt-6 flex items-center space-x-3 text-sm text-gray-400 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Rascunho gerado em {{ $app->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhuma candidatura automática ainda</h3>
                    <p class="text-gray-500 max-w-md mx-auto">A IA irá gerar rascunhos de abordagem (Cover Letters) automaticamente para vagas que tiverem mais de 90% de compatibilidade com o seu perfil.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
