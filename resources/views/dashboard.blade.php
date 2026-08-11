<x-app-layout>
    <x-slot name="title">Painel Central</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
        <!-- Stats Section (Left / Main) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Hero Info Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50 relative overflow-hidden flex flex-col justify-between h-56">
                <div class="z-10">
                    <h2 class="text-gray-500 font-medium">Radar JobPilot</h2>
                    <p class="text-4xl font-extrabold text-gray-900 mt-2">127 novas oportunidades</p>
                    <p class="text-gray-600 mt-2 font-medium">68 são Home Office • 35 com +80% de compatibilidade</p>
                </div>
                <div class="z-10 mt-6">
                    <a href="{{ route('jobs.index') }}" class="inline-block px-6 py-3 bg-[#4f46e5] text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition">Explorar Oportunidades</a>
                </div>
                <!-- Decorative Circle -->
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-50 rounded-full opacity-50 pointer-events-none"></div>
            </div>

            <!-- Timeline / Jobs -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Sugestões de Vagas (IA)</h3>
                    <a href="{{ route('matches.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Ver todas &rarr;</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($matches as $match)
                    <a href="{{ $match->jobPosting->source_url }}" target="_blank" class="block bg-gray-50 rounded-2xl p-5 flex items-center justify-between border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white rounded-xl border border-gray-200 flex items-center justify-center shadow-sm font-bold text-indigo-600">
                                {{ substr(strtoupper($match->jobPosting->job_source_id == 1 ? 'IN' : 'GP'), 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $match->jobPosting->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $match->jobPosting->company }} • {{ ucfirst($match->jobPosting->work_mode) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="bg-{{ $match->score >= 90 ? 'green' : 'indigo' }}-100 text-{{ $match->score >= 90 ? 'green-700' : '[#4f46e5]' }} px-3 py-1 rounded-full text-xs font-bold tracking-wide">{{ $match->score }}% MATCH</span>
                            <span class="text-xs text-gray-400 mt-1">Via IA</span>
                        </div>
                    </a>
                    @empty
                    <div class="text-center text-gray-500 py-4">Nenhuma vaga processada ainda. Aguarde a análise da IA.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Sidebar Stats -->
        <div class="space-y-8">
            <!-- Profile Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-gradient-to-tr from-[#4f46e5] to-purple-400 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg mb-4">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500 text-sm">Membro desde {{ Auth::user()->created_at->format('M Y') }}</p>

                <div class="w-full mt-6 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Vagas Encontradas</span>
                        <span class="font-bold text-gray-900">{{ \App\Models\JobPosting::count() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Candidaturas Ativas</span>
                        <span class="font-bold text-gray-900">{{ \App\Models\Application::where('user_id', auth()->id())->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Score Mínimo Exigido</span>
                        <span class="font-bold text-[#4f46e5] bg-indigo-50 px-2 py-0.5 rounded-full">{{ Auth::user()->profile->min_match_score ?? 'N/A' }}%</span>
                    </div>
                </div>
            </div>

            <!-- System Status Card -->
            <div class="bg-[#4f46e5] rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
                <h3 class="font-bold text-lg mb-2 relative z-10">Status dos Extratores</h3>
                <div class="space-y-3 mt-4 relative z-10 text-sm font-medium">
                    <div class="flex justify-between items-center">
                        <span>LinkedIn</span>
                        <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-400 mr-2"></span> Online</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>InfoJobs</span>
                        <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-400 mr-2"></span> Online</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Gupy</span>
                        <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-400 mr-2"></span> Online</span>
                    </div>
                </div>
                <!-- Background decoration -->
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            </div>
        </div>
    </div>
</x-app-layout>
