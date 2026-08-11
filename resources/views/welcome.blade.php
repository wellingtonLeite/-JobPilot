<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JobPilot - O seu caçador de vagas com IA</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-900 text-white selection:bg-indigo-500 selection:text-white font-['Inter']">
        <div class="relative min-h-screen flex flex-col justify-center overflow-hidden">
            <!-- Efeitos de Fundo (Glow) -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] opacity-30 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 blur-[100px] rounded-full"></div>
            </div>

            <nav class="absolute top-0 w-full px-6 py-8 flex justify-between items-center z-10 max-w-7xl mx-auto left-0 right-0">
                <div class="flex items-center gap-2 font-black text-2xl tracking-tighter">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    Job<span class="text-indigo-400">Pilot</span>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-300 hover:text-white transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-slate-300 hover:text-white transition px-4 py-2">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-bold text-white bg-white/10 hover:bg-white/20 border border-white/10 backdrop-blur-md px-5 py-2 rounded-xl transition shadow-lg">Criar Conta</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>

            <main class="relative z-10 max-w-5xl mx-auto px-6 text-center mt-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 font-semibold text-sm mb-8">
                    <span class="flex w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    Alimentado por Google Gemini 1.5
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-8 leading-tight">
                    O trabalho dos seus sonhos, <br class="hidden md:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">encontrado por Inteligência Artificial.</span>
                </h1>
                
                <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Nós varremos o LinkedIn, Gupy e InfoJobs 24 horas por dia. Nossa IA lê o seu currículo, cruza com milhares de vagas e escreve sua carta de apresentação automaticamente.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white bg-indigo-600 rounded-2xl overflow-hidden transition-transform hover:scale-105 hover:shadow-[0_0_40px_rgba(79,70,229,0.4)]">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 transition-opacity opacity-0 group-hover:opacity-100"></div>
                        <span class="relative">Começar Gratuitamente</span>
                        <svg class="relative w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Preview UI Mockup -->
                <div class="mt-20 relative mx-auto max-w-4xl">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur-xl opacity-30"></div>
                    <div class="relative bg-slate-900/80 backdrop-blur-2xl border border-slate-700/50 rounded-[2rem] p-4 shadow-2xl">
                        <div class="flex items-center gap-2 mb-4 px-2">
                            <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                            <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                            <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-1 bg-slate-800/50 rounded-xl p-6 border border-slate-700/50">
                                <div class="w-10 h-10 bg-indigo-500/20 rounded-lg flex items-center justify-center text-indigo-400 mb-4 font-bold">GP</div>
                                <div class="h-2 w-20 bg-slate-700 rounded mb-2"></div>
                                <div class="h-2 w-32 bg-slate-700 rounded mb-6"></div>
                                <div class="inline-block px-2 py-1 bg-green-500/10 text-green-400 text-xs font-bold rounded">95% MATCH</div>
                            </div>
                            <div class="col-span-1 md:col-span-2 bg-slate-800/50 rounded-xl p-6 border border-slate-700/50">
                                <div class="h-4 w-48 bg-slate-700 rounded mb-4"></div>
                                <div class="h-2 w-full bg-slate-700 rounded mb-2"></div>
                                <div class="h-2 w-full bg-slate-700 rounded mb-2"></div>
                                <div class="h-2 w-3/4 bg-slate-700 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
