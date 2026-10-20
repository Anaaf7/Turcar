@extends('layouts.app')

@section('titulo', 'Catálogo de Veículos — Turcar Concessionária')

@section('conteudo')
    <!-- HERO SECTION (Faithful to interface.jpg) -->
    <section class="relative bg-black-bean overflow-hidden">
        <!-- Background Image + Gradient Overlay -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1920&q=85"
                 alt="Turcar Hero Banner"
                 class="w-full h-full object-cover object-center opacity-55">
            <div class="absolute inset-0 bg-gradient-to-r from-black-bean via-black-bean/80 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-32 md:pt-24 md:pb-40">
            <div class="max-w-xl space-y-5">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-fire-red/20 border border-fire-red/40 text-champagne text-xs font-display font-semibold uppercase tracking-widest">
                    <x-icon name="sparkles" class="w-3.5 h-3.5 text-fire-red" />
                    <span>Showroom Premium Multimarca</span>
                </span>

                <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white leading-tight tracking-tight">
                    Encontre o Carro Perfeito <br>
                    Para Cada <span class="text-fire-red">Jornada</span>
                </h1>

                <p class="text-sm sm:text-base text-champagne/85 leading-relaxed">
                    Explore nossa seleção exclusiva de veículos revisados, com laudo cautelar aprovado e financiamento em até 60x.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <x-button variant="primary" size="lg" href="#catalogo" iconRight="arrow-right">
                        Explorar Estoque
                    </x-button>
                    @auth
                        <x-button variant="champagne" size="lg" :href="route('carros.create')" icon="plus-circle">
                            Novo Veículo
                        </x-button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- OVERLAPPING SEARCH & FILTER BOX (Faithful to interface.jpg) -->
    <section class="relative z-20 -mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{
                 activeTab: '{{ request('status', 'todos') }}',
                 advancedOpen: {{ request()->anyFilled(['ano', 'preco_min', 'status']) ? 'true' : 'false' }}
             }">
        <div class="bg-black-bean rounded-2xl p-3 sm:p-5 shadow-2xl border border-white/10">
            <!-- Top Tabs inside Black Bean bar -->
            <div class="flex flex-wrap items-center justify-between gap-2 px-2 pb-3.5">
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('carros.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-display font-bold transition-colors {{ !request()->filled('status') ? 'bg-white/10 text-fire-red border border-fire-red/40' : 'text-champagne/75 hover:text-white' }}">
                        <x-icon name="car" class="w-4 h-4 text-fire-red" />
                        <span>Comprar Veículo</span>
                    </a>
                    <a href="{{ route('carros.index', ['status' => 'disponivel']) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-display font-bold transition-colors {{ request('status') === 'disponivel' ? 'bg-white/10 text-fire-red border border-fire-red/40' : 'text-champagne/75 hover:text-white' }}">
                        <x-icon name="check-circle-2" class="w-4 h-4 text-fire-red" />
                        <span>Pronta Entrega</span>
                    </a>
                    <a href="{{ route('carros.index', ['cambio' => 'Automático']) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-display font-bold transition-colors {{ request('cambio') === 'Automático' ? 'bg-white/10 text-fire-red border border-fire-red/40' : 'text-champagne/75 hover:text-white' }}">
                        <x-icon name="briefcase" class="w-4 h-4 text-fire-red" />
                        <span>Executivo & Automático</span>
                    </a>
                </div>

                <button type="button"
                        @click="advancedOpen = !advancedOpen"
                        class="inline-flex items-center gap-1.5 text-xs font-display font-semibold text-champagne hover:text-fire-red transition-colors cursor-pointer px-2 py-1">
                    <x-icon name="sliders-horizontal" class="w-3.5 h-3.5 text-fire-red" />
                    <span x-text="advancedOpen ? 'Menos Filtros' : 'Mais Filtros'"></span>
                </button>
            </div>

            <!-- White Filter Card -->
            <form action="{{ route('carros.index') }}" method="GET" class="bg-white rounded-xl p-4 sm:p-5 shadow-inner">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
                    <!-- Marca -->
                    <div>
                        <label for="marca" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Marca
                        </label>
                        <div class="relative">
                            <input type="text" id="marca" name="marca" value="{{ request('marca') }}"
                                   placeholder="Digite a marca..."
                                   class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                        </div>
                    </div>

                    <!-- Modelo -->
                    <div>
                        <label for="modelo" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Modelo
                        </label>
                        <input type="text" id="modelo" name="modelo" value="{{ request('modelo') }}"
                               placeholder="Digite o modelo..."
                               class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                    </div>

                    <!-- Combustível -->
                    <div>
                        <label for="combustivel" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Combustível
                        </label>
                        <select id="combustivel" name="combustivel"
                                class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                            <option value="">Todos</option>
                            @foreach ($combustiveis as $comb)
                                <option value="{{ $comb }}" {{ request('combustivel') == $comb ? 'selected' : '' }}>{{ $comb }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Câmbio -->
                    <div>
                        <label for="cambio" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Câmbio
                        </label>
                        <select id="cambio" name="cambio"
                                class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                            <option value="">Todos</option>
                            @foreach ($cambios as $cam)
                                <option value="{{ $cam }}" {{ request('cambio') == $cam ? 'selected' : '' }}>{{ $cam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Preço Máximo -->
                    <div>
                        <label for="preco_max" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Preço Máximo (R$)
                        </label>
                        <input type="number" step="0.01" id="preco_max" name="preco_max" value="{{ request('preco_max') }}"
                               placeholder="Até R$ 250.000"
                               class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-fire-red hover:bg-fire-red-700 text-white font-display font-bold text-xs uppercase tracking-wider shadow-sm transition-colors cursor-pointer">
                            <x-icon name="search" class="w-4 h-4" />
                            <span>Buscar Carros</span>
                        </button>
                    </div>
                </div>

                <!-- Collapsible Advanced Filters Row (Ano, Preço Mínimo, Status, Limpar) -->
                <div x-show="advancedOpen" x-cloak x-transition class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4 pt-4 border-t border-black-bean/10 items-end">
                    <div>
                        <label for="ano" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Ano do Modelo
                        </label>
                        <input type="number" id="ano" name="ano" value="{{ request('ano') }}"
                               placeholder="Ex: 2023"
                               class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                    </div>

                    <div>
                        <label for="preco_min" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Preço Mínimo (R$)
                        </label>
                        <input type="number" step="0.01" id="preco_min" name="preco_min" value="{{ request('preco_min') }}"
                               placeholder="A partir de R$"
                               class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                    </div>

                    <div>
                        <label for="status" class="block text-[11px] font-display font-bold uppercase tracking-wider text-black-bean-600 mb-1">
                            Status no Estoque
                        </label>
                        <select id="status" name="status"
                                class="w-full rounded-lg border border-black-bean/15 bg-surface px-3 py-2 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                            <option value="">Todos</option>
                            <option value="disponivel" {{ request('status') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                            <option value="reservado" {{ request('status') == 'reservado' ? 'selected' : '' }}>Reservado</option>
                            <option value="vendido" {{ request('status') == 'vendido' ? 'selected' : '' }}>Vendido</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('carros.index') }}"
                           class="inline-flex items-center gap-1.5 text-xs font-display font-semibold text-black-bean-600 hover:text-fire-red py-2">
                            <x-icon name="rotate-ccw" class="w-3.5 h-3.5" />
                            <span>Limpar Filtros</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- 4 FEATURE PILLARS BAR (Faithful to interface.jpg) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-black-bean/10 bg-white rounded-2xl border border-black-bean/10 p-4 shadow-2xs">
            <x-feature-card
                icon="badge-dollar-sign"
                title="Melhor Preço Garantido"
                description="Ofertas competitivas e avaliação justa do seu seminovo." />
            <x-feature-card
                icon="calendar-check"
                title="Financiamento em até 60x"
                description="Simulação transparente de parcelas direto na plataforma." />
            <x-feature-card
                icon="car-front"
                title="Ampla Seleção de Veículos"
                description="Sedans, SUVs, picapes e esportivos revisados com garantia." />
            <x-feature-card
                icon="headset"
                title="Suporte Especializado 24/7"
                description="Consultores prontos para ajudar em todas as etapas." />
        </div>
    </section>

    <!-- POPULAR VEHICLES CATALOG GRID (Faithful to interface.jpg) -->
    <section id="catalogo" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-section-header
            subtitle="VEÍCULOS EM DESTAQUE"
            title="Escolha Seu Carro Perfeito"
            actionText="Ver Todos os Veículos"
            :actionHref="route('carros.index')" />

        @if ($carros->isEmpty())
            <div class="bg-white rounded-2xl border border-black-bean/10 p-12 text-center max-w-lg mx-auto my-6 shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-champagne-100 text-fire-red flex items-center justify-center mx-auto mb-4">
                    <x-icon name="search-x" class="w-8 h-8" />
                </div>
                <h3 class="font-display font-bold text-xl text-black-bean">Nenhum veículo encontrado</h3>
                <p class="text-xs text-black-bean-500 mt-1.5 mb-6">
                    Nenhum veículo corresponde aos critérios de filtro selecionados no momento.
                </p>
                <x-button variant="primary" :href="route('carros.index')" icon="rotate-ccw">
                    Limpar Filtros e Ver Tudo
                </x-button>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($carros as $carro)
                    <x-car-card :carro="$carro" />
                @endforeach
            </div>
        @endif
    </section>

    <!-- PROMOTIONAL BANNER ("Save More on Your Next Adventure" from interface.jpg) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
        <div class="relative rounded-3xl bg-black-bean overflow-hidden shadow-xl border border-white/10">
            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1600&q=80"
                 alt="Condições Especiais Turcar"
                 class="absolute inset-0 w-full h-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-r from-black-bean via-black-bean/90 to-black-bean/75"></div>

            <div class="relative p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left Copy & CTA -->
                <div class="lg:col-span-5 space-y-4">
                    <span class="text-xs font-display font-bold uppercase tracking-widest text-champagne">
                        Condições Exclusivas Turcar
                    </span>
                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-white leading-tight">
                        Economize Mais na Sua <br>Próxima Conquista
                    </h2>
                    <p class="text-xs sm:text-sm text-champagne/80 leading-relaxed">
                        Taxas especiais de financiamento a partir de 1,19% a.m. e bônus na compra à vista via PIX ou TED.
                    </p>
                    <div class="pt-1">
                        <x-button variant="primary" :href="route('carrinho.index')" icon="calculator">
                            Simular no Carrinho
                        </x-button>
                    </div>
                </div>

                <!-- Right 4 Mini Pillars -->
                <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div class="space-y-2">
                        <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/15 text-fire-red flex items-center justify-center mx-auto">
                            <x-icon name="badge-check" class="w-5 h-5" />
                        </div>
                        <h4 class="font-display font-bold text-xs text-white">Sem Taxas Ocultas</h4>
                        <p class="text-[11px] text-champagne/70">Transparência total em cada parcela simulada.</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/15 text-fire-red flex items-center justify-center mx-auto">
                            <x-icon name="gauge" class="w-5 h-5" />
                        </div>
                        <h4 class="font-display font-bold text-xs text-white">Km Certificada</h4>
                        <p class="text-[11px] text-champagne/70">Histórico completo e revisões verificadas.</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/15 text-fire-red flex items-center justify-center mx-auto">
                            <x-icon name="shield" class="w-5 h-5" />
                        </div>
                        <h4 class="font-display font-bold text-xs text-white">Garantia Total</h4>
                        <p class="text-[11px] text-champagne/70">Veículos com cobertura de motor e câmbio.</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/15 text-fire-red flex items-center justify-center mx-auto">
                            <x-icon name="sparkles" class="w-5 h-5" />
                        </div>
                        <h4 class="font-display font-bold text-xs text-white">Compra Rápida</h4>
                        <p class="text-[11px] text-champagne/70">Reserve online em poucos cliques.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER BAR (Faithful to bottom of interface.jpg) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10" x-data="{ subscribed: false, email: '' }">
        <div class="bg-champagne-100/90 border border-champagne-300 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-13 h-13 rounded-full bg-white border border-champagne-400 text-fire-red flex items-center justify-center shrink-0 shadow-xs">
                    <x-icon name="mail" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-display font-bold text-base sm:text-lg text-black-bean">Assine Nossa Newsletter</h3>
                    <p class="text-xs text-black-bean-600">Receba ofertas exclusivas, novidades do estoque e condições especiais.</p>
                </div>
            </div>

            <form @submit.prevent="if(email) subscribed = true" class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <template x-if="!subscribed">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full">
                        <input type="email"
                               x-model="email"
                               placeholder="Digite seu melhor e-mail..."
                               required
                               class="w-full sm:w-72 rounded-xl bg-white border border-black-bean/15 px-4 py-2.5 text-xs text-black-bean focus:outline-none focus:border-fire-red">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-fire-red hover:bg-fire-red-700 text-white font-display font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer">
                            Inscrever-se
                        </button>
                    </div>
                </template>
                <template x-if="subscribed">
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-100 text-emerald-900 text-xs font-display font-semibold">
                        <x-icon name="check-circle-2" class="w-4 h-4 text-emerald-700" />
                        <span>Inscrição confirmada! Você receberá nossas novidades.</span>
                    </div>
                </template>
            </form>
        </div>
    </section>
@endsection
