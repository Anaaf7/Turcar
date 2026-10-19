<footer class="bg-black-bean text-champagne/80 mt-20 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('carros.index') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-fire-red flex items-center justify-center text-white shadow-sm">
                        <x-icon name="gauge" class="w-5 h-5" />
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-extrabold text-2xl leading-none tracking-tight text-white">
                            Tur<span class="text-fire-red">Car</span>
                        </span>
                        <span class="text-[10px] font-display font-bold uppercase tracking-[0.22em] text-champagne/70 mt-0.5">
                            Concessionária
                        </span>
                    </div>
                </a>
                <p class="text-xs text-champagne/70 leading-relaxed max-w-sm">
                    Sua próxima jornada começa aqui. Veículos selecionados com rigoroso padrão de qualidade, garantia de procedência e financiamento em até 60x.
                </p>
                <div class="flex items-center gap-3 pt-1">
                    <a href="{{ route('carros.index') }}" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-fire-red text-champagne hover:text-white flex items-center justify-center transition-colors">
                        <x-icon name="instagram" class="w-4 h-4" />
                    </a>
                    <a href="{{ route('carros.index') }}" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-fire-red text-champagne hover:text-white flex items-center justify-center transition-colors">
                        <x-icon name="facebook" class="w-4 h-4" />
                    </a>
                    <a href="{{ route('carros.index') }}" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-fire-red text-champagne hover:text-white flex items-center justify-center transition-colors">
                        <x-icon name="youtube" class="w-4 h-4" />
                    </a>
                </div>
            </div>

            <!-- Navegação -->
            <div>
                <h4 class="font-display font-bold text-xs uppercase tracking-widest text-white mb-4">Navegação</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ route('carros.index') }}" class="hover:text-fire-red transition-colors">Catálogo Completo</a></li>
                    <li><a href="{{ route('carros.index', ['status' => 'disponivel']) }}" class="hover:text-fire-red transition-colors">Veículos Disponíveis</a></li>
                    <li><a href="{{ route('carrinho.index') }}" class="hover:text-fire-red transition-colors">Carrinho de Compras</a></li>
                    @auth
                        <li><a href="{{ route('carros.create') }}" class="hover:text-fire-red transition-colors">Cadastrar Veículo</a></li>
                        <li><a href="{{ route('usuarios.index') }}" class="hover:text-fire-red transition-colors">Gestão de Usuários</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-fire-red transition-colors">Entrar na Conta</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-fire-red transition-colors">Criar Cadastro</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Serviços -->
            <div>
                <h4 class="font-display font-bold text-xs uppercase tracking-widest text-white mb-4">Serviços</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ route('carros.index') }}" class="hover:text-fire-red transition-colors">Simulação de Financiamento</a></li>
                    <li><a href="{{ route('carros.index', ['cambio' => 'Automático']) }}" class="hover:text-fire-red transition-colors">Veículos Automáticos</a></li>
                    <li><a href="{{ route('carros.index', ['combustivel' => 'Híbrido']) }}" class="hover:text-fire-red transition-colors">Elétricos & Híbridos</a></li>
                    <li><a href="{{ route('carros.index') }}" class="hover:text-fire-red transition-colors">Laudo Cautelar 100%</a></li>
                </ul>
            </div>

            <!-- Contato -->
            <div>
                <h4 class="font-display font-bold text-xs uppercase tracking-widest text-white mb-4">Fale Conosco</h4>
                <ul class="space-y-3 text-xs">
                    <li class="flex items-start gap-2.5">
                        <x-icon name="phone" class="w-4 h-4 text-fire-red shrink-0 mt-0.5" />
                        <span>0800 777 8899<br>(11) 99876-5432</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <x-icon name="mail" class="w-4 h-4 text-fire-red shrink-0" />
                        <span>contato@turcar.com.br</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="map-pin" class="w-4 h-4 text-fire-red shrink-0 mt-0.5" />
                        <span>Av. Europa, 1500 - Jardins<br>São Paulo - SP</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-champagne/50">
            <p>&copy; {{ date('Y') }} Turcar Concessionária de Veículos. Todos os direitos reservados.</p>
            <p class="font-display text-champagne/70">Design inspirado em alta performance automotiva.</p>
        </div>
    </div>
</footer>
