<aside class="w-72 bg-[#4f46e5] text-white flex flex-col rounded-tr-3xl rounded-br-3xl shadow-xl z-10 hidden md:flex">
    <div class="p-8 text-3xl font-extrabold tracking-tight">
        JOBPILOT
    </div>
    
    <nav class="flex-1 px-4 space-y-2 mt-4">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-white text-[#4f46e5] shadow' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} rounded-xl transition-all font-semibold">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Painel Central
        </a>
        
        <a href="{{ route('jobs.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('jobs.index') ? 'bg-white text-[#4f46e5] shadow' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} rounded-xl transition-all font-semibold">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Minhas Vagas
            @php $jobCount = \App\Models\JobPosting::count(); @endphp
            @if($jobCount > 0)
                <span class="ml-auto bg-indigo-400 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $jobCount }}</span>
            @endif
        </a>
        
        <a href="{{ route('matches.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('matches.index') ? 'bg-white text-[#4f46e5] shadow' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} rounded-xl transition-all font-semibold">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Compatibilidade
        </a>

        <a href="{{ route('applications.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('applications.index') ? 'bg-white text-[#4f46e5] shadow' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} rounded-xl transition-all font-semibold">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
            Candidaturas
        </a>

        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.settings') ? 'bg-white text-[#4f46e5] shadow' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} rounded-xl transition-all font-semibold mt-8 border-t border-indigo-700 pt-6">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Admin Config
        </a>
        @endif
    </nav>
    
    <div class="p-6 mt-auto">
        <a href="{{ route('profile.edit') }}" class="block bg-indigo-800 bg-opacity-50 rounded-2xl p-4 hover:bg-opacity-70 transition cursor-pointer">
            <p class="text-sm text-indigo-200">Plano Atual</p>
            <p class="font-bold text-white mt-1">SaaS Gratuito</p>
        </a>
    </div>
</aside>
