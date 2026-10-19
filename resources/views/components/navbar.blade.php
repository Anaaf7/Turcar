@php
    $qtdCarrinho = Auth::check()
        ? \App\Models\Carrinho::where('usuario_id', Auth::id())->sum('quantidade')
        : 0;
@endphp

<header x-data="{ mobileOpen: false, userDropdown: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-black-bean/10 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo (DriveX style from interface.jpg adapted for Turcar) -->
            <a href="{{ route('carros.index') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-black-bean flex items-center justify-center text-fire-red shadow-sm group-hover:bg-fire-red group-hover:text-white transition-colors">
                    <x-icon name="gauge" class="w-6 h-6" />
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-extrabold text-2xl leading-none tracking-tight text-black-bean">
                        Tur<span class="text-fire-red">Car</span>
                    </span>
                    <span class="text-[10px] font-display font-bold uppercase tracking-[0.22em] text-black-bean-500 mt-0.5">
                        Concessionária
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-7">
                <a href="{{ route('carros.index') }}"
                   class="text-xs font-display font-bold uppercase tracking-wider py-2 border-b-2 transition-colors {{ request()->routeIs('carros.index') && !request()->filled('status') ? 'text-fire-red border-fire-red' : 'text-black-bean hover:text-fire-red border-transparent' }}">
                    Início & Catálogo
                </a>

                <a href="{{ route('carros.index', ['status' => 'disponivel']) }}"
                   class="text-xs font-display font-bold uppercase tracking-wider py-2 border-b-2 transition-colors {{ request('status') === 'disponivel' ? 'text-fire-red border-fire-red' : 'text-black-bean hover:text-fire-red border-transparent' }}">
                    Disponíveis
                </a>

                @auth
                    <a href="{{ route('carros.create') }}"
                       class="text-xs font-display font-bold uppercase tracking-wider py-2 border-b-2 transition-colors {{ request()->routeIs('carros.create') ? 'text-fire-red border-fire-red' : 'text-black-bean hover:text-fire-red border-transparent' }}">
                        Cadastrar Veículo
                    </a>

                    <a href="{{ route('usuarios.index') }}"
                       class="text-xs font-display font-bold uppercase tracking-wider py-2 border-b-2 transition-colors {{ request()->routeIs('usuarios.*') ? 'text-fire-red border-fire-red' : 'text-black-bean hover:text-fire-red border-transparent' }}">
                        Usuários
                    </a>
                @endauth

                <a href="{{ route('carrinho.index') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-display font-bold uppercase tracking-wider py-2 border-b-2 transition-colors {{ request()->routeIs('carrinho.*') ? 'text-fire-red border-fire-red' : 'text-black-bean hover:text-fire-red border-transparent' }}">
                    <x-icon name="shopping-cart" class="w-4 h-4 text-fire-red" />
                    <span>Carrinho</span>
                    @if ($qtdCarrinho > 0)
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold bg-fire-red text-white rounded-full">
                            {{ $qtdCarrinho }}
                        </span>
                    @endif
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <div class="relative" @click.outside="userDropdown = false">
                        <button type="button"
                                @click="userDropdown = !userDropdown"
                                class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl bg-champagne-100 hover:bg-champagne-200 text-black-bean text-xs font-display font-semibold border border-champagne-300 transition-colors cursor-pointer">
                            <span class="w-7 h-7 rounded-lg bg-black-bean text-champagne flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->nome, 0, 1)) }}
                            </span>
                            <span class="max-w-[140px] truncate">{{ Auth::user()->nome }}</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-black-bean-600" />
                        </button>

                        <div x-show="userDropdown"
                             x-cloak
                             x-transition
                             class="absolute right-0 mt-2 w-56 rounded-xl bg-white border border-black-bean/10 shadow-xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-black-bean/10">
                                <p class="text-xs font-display font-bold text-black-bean truncate">{{ Auth::user()->nome }}</p>
                                <p class="text-[11px] text-black-bean-500 truncate">{{ Auth::user()->e_mail }}</p>
                            </div>
                            <a href="{{ route('usuarios.show', Auth::user()) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-black-bean hover:bg-champagne-100 transition-colors">
                                <x-icon name="user" class="w-4 h-4 text-fire-red" />
                                <span>Meu Perfil</span>
                            </a>
                            <a href="{{ route('carrinho.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-black-bean hover:bg-champagne-100 transition-colors">
                                <x-icon name="shopping-bag" class="w-4 h-4 text-fire-red" />
                                <span>Meu Carrinho ({{ $qtdCarrinho }})</span>
                            </a>
                            <a href="{{ route('carros.create') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-black-bean hover:bg-champagne-100 transition-colors">
                                <x-icon name="plus-circle" class="w-4 h-4 text-fire-red" />
                                <span>Novo Veículo</span>
                            </a>
                            <div class="border-t border-black-bean/10 mt-1 pt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-fire-red hover:bg-fire-red-50 transition-colors cursor-pointer">
                                        <x-icon name="log-out" class="w-4 h-4" />
                                        <span>Sair (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <x-button variant="ghost" size="sm" :href="route('login')" icon="log-in">
                        Entrar
                    </x-button>
                    <x-button variant="primary" size="sm" :href="route('register')" icon="user-plus">
                        Cadastre-se
                    </x-button>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('carrinho.index') }}" class="relative p-2 rounded-lg text-black-bean hover:bg-champagne-100">
                    <x-icon name="shopping-cart" class="w-5 h-5 text-fire-red" />
                    @if ($qtdCarrinho > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 text-[10px] font-bold bg-fire-red text-white rounded-full flex items-center justify-center">
                            {{ $qtdCarrinho }}
                        </span>
                    @endif
                </a>
                <button type="button" @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-black-bean hover:bg-champagne-100 cursor-pointer">
                    <x-icon name="menu" class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden bg-white border-t border-black-bean/10 px-4 pt-3 pb-5 space-y-2">
        <a href="{{ route('carros.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-display font-semibold text-black-bean hover:bg-champagne-100">
            <x-icon name="car" class="w-4 h-4 text-fire-red" />
            <span>Catálogo de Carros</span>
        </a>
        <a href="{{ route('carrinho.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-display font-semibold text-black-bean hover:bg-champagne-100">
            <x-icon name="shopping-cart" class="w-4 h-4 text-fire-red" />
            <span>Carrinho ({{ $qtdCarrinho }})</span>
        </a>
        @auth
            <a href="{{ route('carros.create') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-display font-semibold text-black-bean hover:bg-champagne-100">
                <x-icon name="plus-circle" class="w-4 h-4 text-fire-red" />
                <span>Cadastrar Novo Carro</span>
            </a>
            <a href="{{ route('usuarios.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-display font-semibold text-black-bean hover:bg-champagne-100">
                <x-icon name="users" class="w-4 h-4 text-fire-red" />
                <span>Listar Usuários</span>
            </a>
            <a href="{{ route('usuarios.show', Auth::user()) }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-display font-semibold text-black-bean hover:bg-champagne-100">
                <x-icon name="user" class="w-4 h-4 text-fire-red" />
                <span>Meu Perfil ({{ Auth::user()->nome }})</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="pt-2 border-t border-black-bean/10">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-fire-red text-white text-sm font-display font-semibold cursor-pointer">
                    <x-icon name="log-out" class="w-4 h-4" />
                    <span>Sair (Logout)</span>
                </button>
            </form>
        @else
            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-black-bean/10">
                <x-button variant="outline" size="sm" :href="route('login')">Entrar</x-button>
                <x-button variant="primary" size="sm" :href="route('register')">Cadastre-se</x-button>
            </div>
        @endauth
    </div>
</header>
