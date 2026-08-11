<header class="flex justify-between items-center px-10 py-6">
    <h1 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Painel Central' }}</h1>
    
    <div class="flex items-center space-x-6">
        <div class="relative hidden sm:block">
            <input type="text" placeholder="Buscar vagas..." class="pl-4 pr-10 py-2 border-none rounded-xl shadow-sm text-sm focus:ring-2 focus:ring-[#4f46e5] bg-white w-64">
            <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        
        <div class="flex items-center space-x-3 bg-white p-1 pr-4 rounded-full shadow-sm border border-gray-100">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#4f46e5] to-purple-400 text-white flex items-center justify-center font-bold text-sm shadow-inner">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 transition">{{ explode(' ', Auth::user()->name)[0] }}</a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Sair do sistema">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
</header>
