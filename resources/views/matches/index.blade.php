<x-app-layout>
    <x-slot name="title">Compatibilidade IA</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Análise de Compatibilidade</h1>
                <p class="text-gray-500 mt-2">Vagas analisadas pela IA e ordenadas pelo Score de Match com o seu perfil.</p>
            </div>

            <div class="space-y-6">
                @forelse($matches as $match)
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-8 items-center transition hover:shadow-md">
                    <!-- Score Circle -->
                    <div class="flex-shrink-0 w-32 h-32 rounded-full flex items-center justify-center border-8 {{ $match->score >= 80 ? 'border-green-100' : 'border-indigo-100' }}">
                        <div class="text-center">
                            <span class="block text-3xl font-extrabold {{ $match->score >= 80 ? 'text-green-600' : 'text-indigo-600' }}">{{ $match->score }}%</span>
                            <span class="text-xs font-bold text-gray-400">MATCH</span>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $match->jobPosting->title }}</h3>
                                <p class="text-indigo-600 font-semibold">{{ $match->jobPosting->company }} • {{ ucfirst($match->jobPosting->work_mode) }}</p>
                            </div>
                            <a href="{{ $match->jobPosting->source_url }}" target="_blank" class="px-4 py-2 bg-gray-50 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-100 transition">Link Original</a>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm font-bold text-gray-700 mb-2">Hard Skills Identificadas:</p>
                            <div class="flex flex-wrap gap-2">
                                @php 
                                    $skills = json_decode($match->hard_skills_matched, true) ?? []; 
                                @endphp
                                @foreach($skills as $skill)
                                    <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-md">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-white rounded-[2rem] border border-gray-100">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Nenhum Match Encontrado</h3>
                    <p class="text-gray-500 mt-2">O motor da IA ainda não analisou vagas ou seu perfil não obteve a pontuação mínima.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $matches->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
