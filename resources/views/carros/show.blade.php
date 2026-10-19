@extends('layouts.app')

@section('titulo', $carro->marca . ' ' . $carro->modelo . ' — Turcar Concessionária')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
         qtd: 1,
         maxQtd: {{ max(1, (int) $carro->quantidade_disponivel) }},
         parcelaSelecionada: {{ $simulacoes[0]['parcelas'] ?? 12 }}
     }">

    <!-- Breadcrumb & Top Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <nav class="flex items-center gap-2 text-xs text-black-bean-500 font-medium">
            <a href="{{ route('carros.index') }}" class="hover:text-fire-red transition-colors flex items-center gap-1">
                <x-icon name="home" class="w-3.5 h-3.5" />
                <span>Catálogo</span>
            </a>
            <x-icon name="chevron-right" class="w-3.5 h-3.5 opacity-50" />
            <span class="text-fire-red font-semibold">{{ $carro->marca }}</span>
            <x-icon name="chevron-right" class="w-3.5 h-3.5 opacity-50" />
            <span class="text-black-bean font-bold">{{ $carro->modelo }}</span>
        </nav>

        <div class="flex items-center gap-2">
            <x-button variant="outline" size="xs" :href="route('carros.index')" icon="arrow-left">
                Voltar para o Catálogo
            </x-button>
            @auth
                <x-button variant="secondary" size="xs" :href="route('carros.edit', $carro)" icon="pencil">
                    Editar este Veículo
                </x-button>
            @endauth
        </div>
    </div>

    <!-- Main 2-Column Showroom Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left 7 Columns: Vehicle Photo & Specifications -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl border border-black-bean/10 overflow-hidden shadow-sm">
                <div class="relative aspect-[16/10] bg-champagne-50">
                    <img src="{{ $carro->imagem }}"
                         alt="{{ $carro->marca }} {{ $carro->modelo }}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80';">
                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <x-badge :status="$carro->status" />
                        <span class="px-3 py-1 rounded-full text-xs font-display font-bold bg-black-bean/90 text-champagne">
                            Ano {{ $carro->ano }}
                        </span>
                    </div>
                </div>

                <!-- Description Box -->
                <div class="p-6 sm:p-8">
                    <h3 class="font-display font-bold text-base text-black-bean flex items-center gap-2 mb-2">
                        <x-icon name="file-text" class="w-4 h-4 text-fire-red" />
                        <span>Sobre este Veículo</span>
                    </h3>
                    <p class="text-sm text-black-bean-600 leading-relaxed">
                        {{ $carro->descricao }}
                    </p>
                </div>
            </div>

            <!-- Technical Specs Grid -->
            <div class="bg-white rounded-3xl border border-black-bean/10 p-6 sm:p-8 shadow-xs">
                <h3 class="font-display font-bold text-lg text-black-bean mb-5 flex items-center gap-2">
                    <x-icon name="sliders" class="w-5 h-5 text-fire-red" />
                    <span>Ficha Técnica Completa</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Marca</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->marca }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Modelo</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->modelo }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Ano</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->ano }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Quilometragem</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ number_format($carro->quilometragem, 0, ',', '.') }} km</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Combustível</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->combustivel }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Câmbio</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->cambio }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Cor</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->cor }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface border border-black-bean/10">
                        <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Portas / Estoque</span>
                        <span class="font-display font-bold text-sm text-black-bean mt-0.5 block">{{ $carro->numero_portas }}p • {{ $carro->quantidade_disponivel }} un.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 5 Columns: Purchase Card & Highlights -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl border border-black-bean/10 p-6 sm:p-8 shadow-md sticky top-24">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-display font-bold uppercase tracking-widest text-fire-red">{{ $carro->marca }}</span>
                    <x-badge :status="$carro->status" />
                </div>

                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-black-bean leading-tight">
                    {{ $carro->modelo }}
                </h1>
                <p class="text-sm text-black-bean-500 mt-1">{{ $carro->versao }}</p>

                <div class="my-6 p-5 rounded-2xl bg-black-bean text-white flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-display uppercase tracking-widest text-champagne/75 block">Preço à Vista</span>
                        <span class="font-display font-extrabold text-3xl text-fire-red tracking-tight">
                            R$ {{ number_format($carro->preco, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] text-champagne/75 block">Estoque</span>
                        <span class="font-display font-bold text-sm text-champagne">{{ $carro->quantidade_disponivel }} disponíveis</span>
                    </div>
                </div>

                @if ($carro->isDisponivel())
                    <form action="{{ route('carrinho.adicionar', $carro) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="quantidade" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-2">
                                Quantidade desejada
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="inline-flex items-center rounded-xl border border-black-bean/15 bg-surface p-1">
                                    <button type="button"
                                            @click="if(qtd > 1) qtd--"
                                            class="w-9 h-9 rounded-lg hover:bg-white text-black-bean flex items-center justify-center font-bold cursor-pointer">
                                        -
                                    </button>
                                    <input type="number"
                                           id="quantidade"
                                           name="quantidade"
                                           x-model="qtd"
                                           min="1"
                                           max="{{ $carro->quantidade_disponivel }}"
                                           required
                                           class="w-14 text-center font-display font-bold text-sm text-black-bean bg-transparent focus:outline-none">
                                    <button type="button"
                                            @click="if(qtd < maxQtd) qtd++"
                                            class="w-9 h-9 rounded-lg hover:bg-white text-black-bean flex items-center justify-center font-bold cursor-pointer">
                                        +
                                    </button>
                                </div>
                                <span class="text-xs text-black-bean-500">
                                    Subtotal: <strong class="text-black-bean" x-text="'R$ ' + (qtd * {{ (float) $carro->preco }}).toLocaleString('pt-BR', { minimumFractionDigits: 2 })"></strong>
                                </span>
                            </div>
                        </div>

                        <x-button type="submit" variant="primary" size="lg" class="w-full" icon="shopping-cart">
                            Adicionar ao Carrinho
                        </x-button>
                    </form>
                @else
                    <div class="p-4 rounded-2xl bg-fire-red-50 border border-fire-red-200 text-center">
                        <p class="font-display font-bold text-sm text-fire-red-800">Veículo indisponível no momento.</p>
                        <p class="text-xs text-fire-red-700 mt-0.5">Consulte outras opções disponíveis em nosso catálogo.</p>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-black-bean/10 space-y-2.5 text-xs text-black-bean-600">
                    <div class="flex items-center gap-2.5">
                        <x-icon name="shield-check" class="w-4 h-4 text-fire-red" />
                        <span>Garantia Turcar de 1 ano para motor e câmbio</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <x-icon name="check-circle-2" class="w-4 h-4 text-fire-red" />
                        <span>Laudo cautelar 100% aprovado sem restrições</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FINANCING SIMULATION SECTION -->
    <section class="mt-12 bg-white rounded-3xl border border-black-bean/10 p-6 sm:p-8 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <span class="text-xs font-display font-bold uppercase tracking-widest text-fire-red">Financiamento Turcar</span>
                <h3 class="font-display font-bold text-xl text-black-bean mt-0.5">
                    Simulacao de Parcelamento e Financiamento
                </h3>
            </div>
            <span class="text-xs text-black-bean-500">Selecione um prazo para destacar as condições:</span>
        </div>

        <!-- Quick Interactive Installment Cards (Alpine.js) -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-6">
            @foreach ($simulacoes as $sim)
                <button type="button"
                        @click="parcelaSelecionada = {{ $sim['parcelas'] }}"
                        :class="parcelaSelecionada === {{ $sim['parcelas'] }} ? 'bg-black-bean text-white border-black-bean shadow-md' : 'bg-surface text-black-bean border-black-bean/10 hover:border-fire-red/40'"
                        class="p-4 rounded-2xl border text-left transition-all cursor-pointer">
                    <div class="flex items-center justify-between">
                        <span class="font-display font-extrabold text-lg text-fire-red">{{ $sim['parcelas'] }}x</span>
                        <span class="text-[11px] opacity-75">{{ $sim['taxa_mensal'] }}% a.m.</span>
                    </div>
                    <p class="font-display font-bold text-sm mt-1.5">
                        R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }}
                    </p>
                    <p class="text-[10px] opacity-70 mt-0.5">
                        Total: R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }}
                    </p>
                </button>
            @endforeach
        </div>

        <!-- Full Simulation Table -->
        <div class="overflow-x-auto rounded-2xl border border-black-bean/10">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-black-bean text-champagne font-display text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-4">Prazo</th>
                        <th class="py-3.5 px-4">Taxa Mensal</th>
                        <th class="py-3.5 px-4">Valor da Parcela</th>
                        <th class="py-3.5 px-4">Total com Juros</th>
                        <th class="py-3.5 px-4">Total de Juros</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black-bean/10">
                    @foreach ($simulacoes as $sim)
                        <tr :class="parcelaSelecionada === {{ $sim['parcelas'] }} ? 'bg-champagne-100/80 font-semibold' : 'hover:bg-surface'" class="transition-colors">
                            <td class="py-3.5 px-4 font-display font-bold text-fire-red">{{ $sim['parcelas'] }}x</td>
                            <td class="py-3.5 px-4">{{ $sim['taxa_mensal'] }}% a.m.</td>
                            <td class="py-3.5 px-4 font-display font-bold text-black-bean">R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }}</td>
                            <td class="py-3.5 px-4">R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-black-bean-500">R$ {{ number_format($sim['total_juros'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
