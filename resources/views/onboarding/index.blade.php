<x-app-layout>
    <div class="py-12 bg-[#f0f4f8] min-h-screen flex items-center justify-center">
        <div class="max-w-3xl w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 sm:p-12 text-gray-900">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Vamos conhecer seu perfil.</h2>
                        <p class="mt-2 text-gray-500">Configure suas preferências para que o JobPilot encontre as melhores oportunidades.</p>
                    </div>

                    <form method="POST" action="{{ route('onboarding') }}" enctype="multipart/form-data" class="space-y-8" x-data="{ minScore: 70 }">
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

                        <!-- Idiomas -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition duration-200 hover:border-[#4f46e5]">
                            <div class="mb-4">
                                <label class="block text-lg font-semibold text-gray-900 mb-1">Qual o seu nível de proficiência em Inglês?</label>
                                <span class="block text-sm text-gray-500 mb-2">Isso ajudará a IA a focar em vagas que exigem ou valorizam o idioma.</span>
                                <select name="english_level" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-[#4f46e5] text-gray-700">
                                    <option value="Não falo">Não falo / Básico (Leitura)</option>
                                    <option value="Básico">Básico (Comunicação simples)</option>
                                    <option value="Intermediário">Intermediário</option>
                                    <option value="Avançado">Avançado</option>
                                    <option value="Fluente/Nativo">Fluente / Nativo</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block font-semibold text-gray-900 mb-1">Quais outros idiomas você fala?</label>
                                <span class="block text-sm text-gray-500 mb-2">Opcional. Ex: Espanhol (Avançado), Francês (Básico).</span>
                                <input type="text" name="other_languages" placeholder="Ex: Espanhol Nativo" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-[#4f46e5] text-gray-700">
                            </div>
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

                        <!-- Resume Upload / Text -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition duration-200 hover:border-[#4f46e5]">
                            <label class="block mb-4">
                                <span class="block text-lg font-semibold text-gray-900">Seu Currículo Profissional</span>
                                <span class="block text-sm text-gray-500 mt-1">Envie o PDF do seu currículo ou cole o texto do seu LinkedIn. A IA usará isso para extrair suas Skills e calcular a compatibilidade.</span>
                            </label>
                            
                            <div class="mb-4">
                                <span class="block text-sm font-bold text-indigo-600 mb-2">Opção 1: Upload de PDF (Recomendado)</span>
                                <input type="file" name="resume_pdf" accept=".pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                            </div>
                            
                            <div class="flex items-center text-gray-400 my-4 before:flex-1 before:border-t before:border-gray-200 before:mr-4 after:flex-1 after:border-t after:border-gray-200 after:ml-4">
                                ou
                            </div>

                            <div>
                                <span class="block text-sm font-bold text-gray-600 mb-2">Opção 2: Colar Texto Manualmente</span>
                                <textarea name="resume_text" rows="5" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-[#4f46e5] text-gray-700" placeholder="Cole aqui seu texto se não quiser enviar o PDF..."></textarea>
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
