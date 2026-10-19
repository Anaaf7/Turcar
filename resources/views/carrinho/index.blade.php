@extends('layouts.app')

@section('titulo', 'Meu Carrinho de Compras — Turcar Concessionária')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{
         metodoPagamento: 'a_vista',
         parcelaEscolhida: '1'
     }">

    <x-section-header
        subtitle="CHECKOUT & RESERVA"
        title="Meu Carrinho de Compras"
        description="Revise os veículos selecionados, simule condições de parcelamento e finalize seu pedido."
        actionText="Continuar Comprando"
        :actionHref="route('carros.index')" />

    @if ($itens->isEmpty())
        <div class="bg-white rounded-3xl border border-black-bean/10 p-12 text-center max-w-lg mx-auto my-8 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-champagne-100 text-fire-red flex items-center justify-center mx-auto mb-4">
                <x-icon name="shopping-cart" class="w-8 h-8" />
            </div>
            <h3 class="font-display font-bold text-xl text-black-bean">Seu carrinho de compras está vazio</h3>
            <p class="text-xs text-black-bean-500 mt-1.5 mb-6">
                Explore nosso catálogo de veículos e escolha o carro ideal para sua próxima jornada.
            </p>
            <x-button variant="primary" :href="route('carros.index')" icon="car">
                Explorar Catálogo de Veículos
            </x-button>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left 8 Columns: Cart Items & Financing Table -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Items Card List -->
                <div class="bg-white rounded-3xl border border-black-bean/10 overflow-hidden shadow-xs">
                    <div class="px-6 py-4 bg-black-bean text-champagne flex items-center justify-between">
                        <span class="font-display font-bold text-xs uppercase tracking-wider flex items-center gap-2">
                            <x-icon name="shopping-bag" class="w-4 h-4 text-fire-red" />
                            <span>Veículos Selecionados ({{ $itens->count() }})</span>
                        </span>

                        <form action="{{ route('carrinho.limpar') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja esvaziar todo o carrinho?')">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-display font-semibold text-champagne/80 hover:text-fire-red transition-colors cursor-pointer">
                                <x-icon name="trash-2" class="w-3.5 h-3.5" />
                                <span>Limpar Todo o Carrinho</span>
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-black-bean/10">
                        @foreach ($itens as $item)
                            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 hover:bg-surface/60 transition-colors">
                                <!-- Vehicle Info -->
                                <div class="flex items-center gap-4">
                                    @if ($item->carro)
                                        <a href="{{ route('carros.show', $item->carro) }}" class="w-28 h-20 rounded-xl overflow-hidden bg-champagne-100 shrink-0 border border-black-bean/10">
                                            <img src="{{ $item->carro->imagem }}"
                                                 alt="{{ $item->carro->modelo }}"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=600&q=80';">
                                        </a>
                                        <div>
                                            <span class="text-[10px] font-display font-bold uppercase tracking-widest text-fire-red block">
                                                {{ $item->carro->marca }} • {{ $item->carro->ano }}
                                            </span>
                                            <a href="{{ route('carros.show', $item->carro) }}" class="font-display font-bold text-base text-black-bean hover:text-fire-red transition-colors">
                                                {{ $item->carro->modelo }}
                                            </a>
                                            <p class="text-xs text-black-bean-500">{{ $item->carro->versao }}</p>
                                            <p class="text-xs font-medium text-black-bean-600 mt-1">
                                                Unitário: R$ {{ number_format($item->carro->preco, 2, ',', '.') }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-sm text-black-bean-500">Veículo não encontrado</span>
                                    @endif
                                </div>

                                <!-- Quantity, Subtotal & Remove -->
                                <div class="w-full sm:w-auto flex flex-wrap items-center justify-between sm:justify-end gap-4 pt-3 sm:pt-0 border-t sm:border-t-0 border-black-bean/10">
                                    <form action="{{ route('carrinho.atualizar', $item) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <label class="text-[11px] text-black-bean-500 font-medium">Qtd:</label>
                                        <input type="number"
                                               name="quantidade"
                                               value="{{ $item->quantidade }}"
                                               min="1"
                                               max="{{ $item->carro ? $item->carro->quantidade_disponivel : 1 }}"
                                               class="w-16 rounded-lg border border-black-bean/15 bg-surface px-2.5 py-1.5 text-center font-display font-bold text-xs text-black-bean focus:outline-none focus:border-fire-red">
                                        <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-champagne-100 hover:bg-champagne-200 text-black-bean text-xs font-display font-semibold transition-colors cursor-pointer">
                                            Atualizar
                                        </button>
                                    </form>

                                    <div class="text-right min-w-[125px]">
                                        <span class="text-[10px] uppercase tracking-wider text-black-bean-400 block font-semibold">Subtotal</span>
                                        <strong class="font-display font-extrabold text-base text-fire-red">
                                            R$ {{ number_format($item->subtotal, 2, ',', '.') }}
                                        </strong>
                                    </div>

                                    <form action="{{ route('carrinho.remover', $item) }}" method="POST" onsubmit="return confirm('Remover este item do carrinho?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Remover item"
                                                class="w-9 h-9 rounded-xl bg-fire-red-50 hover:bg-fire-red text-fire-red hover:text-white flex items-center justify-center transition-colors cursor-pointer">
                                            <x-icon name="trash-2" class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Financing Simulation Table -->
                <div class="bg-white rounded-3xl border border-black-bean/10 p-6 sm:p-8 shadow-xs">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div>
                            <span class="text-xs font-display font-bold uppercase tracking-widest text-fire-red">Planejamento Financeiro</span>
                            <h3 class="font-display font-bold text-lg text-black-bean">
                                Simulacao de Financiamento e Parcelamento do Carrinho
                            </h3>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-black-bean/10">
                        <table class="w-full text-left border-collapse text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-black-bean text-champagne font-display text-xs uppercase tracking-wider">
                                    <th class="py-3 px-4">Prazo</th>
                                    <th class="py-3 px-4">Taxa Mensal</th>
                                    <th class="py-3 px-4">Valor da Parcela</th>
                                    <th class="py-3 px-4">Total com Juros</th>
                                    <th class="py-3 px-4">Total de Juros</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black-bean/10">
                                @foreach ($simulacoes as $sim)
                                    <tr class="hover:bg-champagne-50/70 transition-colors cursor-pointer"
                                        @click="parcelaEscolhida = '{{ $sim['parcelas'] }}'; metodoPagamento = 'financiamento'">
                                        <td class="py-3 px-4 font-display font-bold text-fire-red">{{ $sim['parcelas'] }}x</td>
                                        <td class="py-3 px-4">{{ $sim['taxa_mensal'] }}% a.m.</td>
                                        <td class="py-3 px-4 font-display font-bold text-black-bean">R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }}</td>
                                        <td class="py-3 px-4">R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-black-bean-500">R$ {{ number_format($sim['total_juros'], 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right 4 Columns: Order Summary & Checkout Form -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-3xl border border-black-bean/10 p-6 sm:p-7 shadow-md sticky top-24">
                    <h3 class="font-display font-bold text-lg text-black-bean flex items-center gap-2 pb-4 border-b border-black-bean/10">
                        <x-icon name="credit-card" class="w-5 h-5 text-fire-red" />
                        <span>Finalizar Compra</span>
                    </h3>

                    <div class="my-5 p-5 rounded-2xl bg-black-bean text-white">
                        <span class="text-[11px] font-display uppercase tracking-widest text-champagne/75 block">Valor Total do Carrinho</span>
                        <span class="font-display font-extrabold text-2xl sm:text-3xl text-fire-red block mt-1">
                            R$ {{ number_format($total, 2, ',', '.') }}
                        </span>
                    </div>

                    <form action="{{ route('carrinho.finalizar') }}" method="POST" class="space-y-5" onsubmit="return confirm('Confirma a finalização da compra?')">
                        @csrf

                        <div>
                            <label for="metodo" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-2">
                                Forma de Pagamento
                            </label>
                            <select id="metodo"
                                    name="metodo"
                                    x-model="metodoPagamento"
                                    required
                                    class="w-full rounded-xl border border-black-bean/15 bg-surface px-3.5 py-2.5 text-sm text-black-bean focus:outline-none focus:border-fire-red">
                                <option value="a_vista">Pagamento à Vista (TED / PIX)</option>
                                <option value="financiamento">Financiamento Bancário</option>
                                <option value="cartao_credito">Cartão de Crédito</option>
                            </select>
                        </div>

                        <div>
                            <label for="parcelas" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-2">
                                Condição de Parcelamento
                            </label>
                            <select id="parcelas"
                                    name="parcelas"
                                    x-model="parcelaEscolhida"
                                    class="w-full rounded-xl border border-black-bean/15 bg-surface px-3.5 py-2.5 text-sm text-black-bean focus:outline-none focus:border-fire-red">
                                <option value="1">1x à Vista - R$ {{ number_format($total, 2, ',', '.') }}</option>
                                @foreach ($simulacoes as $sim)
                                    <option value="{{ $sim['parcelas'] }}">
                                        {{ $sim['parcelas'] }}x de R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }} (Total: R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <x-button type="submit" variant="primary" size="lg" class="w-full" icon="check-circle-2">
                            Confirmar e Finalizar Compra
                        </x-button>
                    </form>

                    <div class="mt-6 pt-5 border-t border-black-bean/10 space-y-2 text-xs text-black-bean-500">
                        <p class="flex items-center gap-2">
                            <x-icon name="lock" class="w-3.5 h-3.5 text-fire-red" />
                            <span>Transação protegida com atualização imediata de estoque.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
