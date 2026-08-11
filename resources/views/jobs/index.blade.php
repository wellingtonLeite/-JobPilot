<x-app-layout>
    <x-slot name="title">Minhas Vagas</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Banco de Vagas</h1>
                    <p class="text-gray-500 mt-2">Explore as {{ $jobs->total() }} vagas brutas coletadas pelo robô em todas as plataformas.</p>
                </div>

                <div class="flex flex-col gap-2 md:flex-row md:items-center">
                    <form method="POST" action="{{ route('jobs.sync') }}" class="mr-2">
                        @csrf
                        <button type="submit" class="bg-white border-2 border-[#4f46e5] text-[#4f46e5] px-4 py-2 rounded-xl font-bold shadow-sm hover:bg-indigo-50 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Buscar Novas Vagas
                        </button>
                    </form>
                    <form method="GET" action="{{ route('jobs.index') }}" class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar cargo ou empresa" class="rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <select name="work_mode" class="rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Qualquer modelo</option>
                            <option value="remoto" {{ request('work_mode') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                            <option value="hibrido" {{ request('work_mode') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                            <option value="presencial" {{ request('work_mode') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                        </select>
                        <button type="submit" class="bg-[#4f46e5] text-white px-4 py-2 rounded-xl font-bold shadow-sm hover:bg-indigo-700">Filtrar</button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jobs as $job)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center font-bold text-indigo-600">
                                {{ substr(strtoupper($job->job_source_id == 1 ? 'IN' : 'GP'), 0, 2) }}
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-gray-100 text-gray-600 rounded-md">{{ $job->posted_at ? $job->posted_at->diffForHumans() : 'Recente' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $job->title }}</h3>
                        <p class="text-indigo-600 font-semibold text-sm mb-3">{{ $job->company }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-md">{{ ucfirst($job->work_mode) }}</span>
                            <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs font-bold rounded-md">{{ $job->location ?? 'Brasil' }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ $job->source_url }}" target="_blank" class="w-full text-center block px-4 py-2 bg-gray-50 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition">Ver Vaga Original</a>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <p class="text-gray-500">Nenhuma vaga encontrada com esses filtros.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
