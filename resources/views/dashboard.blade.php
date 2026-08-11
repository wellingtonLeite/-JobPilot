<x-app-layout>
    <div class="min-h-screen bg-[#f0f4f8] flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-[#4f46e5] text-white flex flex-col rounded-tr-3xl rounded-br-3xl shadow-xl z-10 hidden md:flex">
            <div class="p-8 text-3xl font-extrabold tracking-tight">
                JOBPILOT
            </div>
            
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="#" class="flex items-center px-4 py-3 bg-white text-[#4f46e5] rounded-xl shadow font-semibold transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Painel Central
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-indigo-100 hover:bg-indigo-700 hover:text-white rounded-xl transition-all font-medium">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Minhas Vagas
                    <span class="ml-auto bg-indigo-400 text-white text-xs font-bold px-2 py-0.5 rounded-full">12</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-indigo-100 hover:bg-indigo-700 hover:text-white rounded-xl transition-all font-medium">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Compatibilidade
                </a>
            </nav>
            
            <div class="p-6 mt-auto">
                <div class="bg-indigo-800 bg-opacity-50 rounded-2xl p-4">
                    <p class="text-sm text-indigo-200">Sua assinatura</p>
                    <p class="font-bold text-white mt-1">Premium Plan</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Top Header -->
            <header class="flex justify-between items-center px-10 py-6">
                <h1 class="text-2xl font-bold text-gray-800">Bom dia, {{ Auth::user()->name }}</h1>
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <input type="text" placeholder="Buscar vagas..." class="pl-4 pr-10 py-2 border-none rounded-xl shadow-sm text-sm focus:ring-2 focus:ring-[#4f46e5] bg-white w-64">
                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-900 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto px-10 pb-10">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
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
                                <button class="px-6 py-3 bg-[#4f46e5] text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition">Explorar Oportunidades</button>
                            </div>
                            <!-- Decorative Circle -->
                            <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-50 rounded-full opacity-50 pointer-events-none"></div>
                        </div>

                        <!-- Timeline / Jobs -->
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Sugestões de Vagas (IA)</h3>
                            
                            <div class="space-y-4">
                                <!-- Job Item -->
                                <div class="bg-gray-50 rounded-2xl p-5 flex items-center justify-between border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition cursor-pointer">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-white rounded-xl border border-gray-200 flex items-center justify-center shadow-sm font-bold text-indigo-600">IN</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Engenheiro de Software Sênior</h4>
                                            <p class="text-sm text-gray-500">TechCorp S.A • Remoto</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">94% MATCH</span>
                                        <span class="text-xs text-gray-400 mt-1">Via LinkedIn</span>
                                    </div>
                                </div>

                                <!-- Job Item 2 -->
                                <div class="bg-gray-50 rounded-2xl p-5 flex items-center justify-between border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition cursor-pointer">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-white rounded-xl border border-gray-200 flex items-center justify-center shadow-sm font-bold text-blue-600">GU</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Arquiteto de Automação (n8n)</h4>
                                            <p class="text-sm text-gray-500">Fintech BR • Híbrido</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="bg-indigo-100 text-[#4f46e5] px-3 py-1 rounded-full text-xs font-bold tracking-wide">88% MATCH</span>
                                        <span class="text-xs text-gray-400 mt-1">Via Gupy</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Sidebar Stats -->
                    <div class="space-y-8">
                        <!-- Profile Card -->
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50 flex flex-col items-center text-center">
                            <div class="w-24 h-24 bg-gradient-to-tr from-[#4f46e5] to-purple-400 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-gray-500 text-sm">Membro desde {{ Auth::user()->created_at->format('M Y') }}</p>

                            <div class="w-full mt-6 space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Candidaturas Ativas</span>
                                    <span class="font-bold text-gray-900">8</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Filtro Atual</span>
                                    <span class="font-bold text-[#4f46e5] bg-indigo-50 px-2 py-0.5 rounded-full">
                                        {{ Auth::user()->profile->home_office_only ? 'Só Remoto' : 'Remoto/Híbrido' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Score Mínimo Exigido</span>
                                    <span class="font-bold text-[#4f46e5] bg-indigo-50 px-2 py-0.5 rounded-full">{{ Auth::user()->profile->min_match_score }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- System Status Card -->
                        <div class="bg-[#4f46e5] rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
                            <h3 class="font-bold text-lg mb-2 relative z-10">Status dos Adapters</h3>
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
            </div>
        </main>
    </div>
</x-app-layout>
