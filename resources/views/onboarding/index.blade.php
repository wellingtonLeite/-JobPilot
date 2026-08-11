<x-app-layout>
    <div class="py-12 bg-[#f0f4f8] min-h-screen flex items-center justify-center">
        <div class="max-w-3xl w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 sm:p-12 text-gray-900">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Vamos conhecer seu perfil.</h2>
                        <p class="mt-2 text-gray-500">Configure suas preferências para que o JobPilot encontre as melhores oportunidades.</p>
                    </div>

                    <form method="POST" action="{{ route('onboarding') }}" class="space-y-8" x-data="{ minScore: 70 }">
                        @csrf

                        <!-- Home Office -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition duration-200 hover:border-[#4f46e5]">
                            <label class="flex items-start space-x-4 cursor-pointer">
                                <div class="flex items-center h-6">
                                    <input id="home_office_only" name="home_office_only" type="checkbox" value="1" class="w-5 h-5 text-[#4f46e5] border-gray-300 rounded focus:ring-[#4f46e5]">
                                </div>
                                <div>
                                    <span class="block text-lg font-semibold text-gray-900">Você aceita apenas Home Office?</span>
                                    <span class="block text-sm text-gray-500 mt-1">Marque esta opção se você não tem interesse em vagas presenciais ou híbridas.</span>
                                </div>
                            </label>
                        </div>

                        <!-- English Proficiency -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition duration-200 hover:border-[#4f46e5]">
                            <label class="flex items-start space-x-4 cursor-pointer">
                                <div class="flex items-center h-6">
                                    <input id="has_english_proficiency" name="has_english_proficiency" type="checkbox" value="1" class="w-5 h-5 text-[#4f46e5] border-gray-300 rounded focus:ring-[#4f46e5]">
                                </div>
                                <div>
                                    <span class="block text-lg font-semibold text-gray-900">Você possui proficiência profissional em inglês?</span>
                                    <span class="block text-sm text-gray-500 mt-1">Isso ajudará a IA a focar em vagas que exigem ou valorizam o idioma.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Match Score -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition duration-200 hover:border-[#4f46e5]">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <label for="min_match_score" class="block text-lg font-semibold text-gray-900">Qual é o score mínimo de compatibilidade que deseja?</label>
                                    <span class="block text-sm text-gray-500 mt-1">Evitaremos desperdiçar seu tempo com vagas abaixo dessa pontuação.</span>
                                </div>
                                <div class="bg-[#4f46e5] text-white font-bold text-xl px-4 py-2 rounded-xl" x-text="minScore + '%'">
                                    70%
                                </div>
                            </div>
                            <input type="range" id="min_match_score" name="min_match_score" min="0" max="100" x-model="minScore" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#4f46e5]">
                            <div class="flex justify-between text-xs text-gray-400 font-semibold mt-2 px-1">
                                <span>0%</span>
                                <span>100%</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10">
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-4 bg-[#4f46e5] border border-transparent rounded-xl font-bold text-white text-lg tracking-wide hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-[#4f46e5] focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-200">
                                Finalizar Configuração
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
