@props([
    'carro',
])

<article x-data="{ liked: false }" class="group bg-white rounded-2xl border border-black-bean/10 hover:border-fire-red/40 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
    <!-- Vehicle Image Box (faithful to interface.jpg cards) -->
    <div class="relative aspect-[16/10] bg-champagne-50/70 overflow-hidden">
        <a href="{{ route('carros.show', $carro) }}" class="block w-full h-full">
            <img src="{{ $carro->imagem }}"
                 alt="{{ $carro->marca }} {{ $carro->modelo }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80';">
        </a>

        <!-- Top Left Status Badge -->
        <div class="absolute top-3 left-3 flex items-center gap-1.5">
            <x-badge :status="$carro->status" />
            <span class="px-2 py-0.5 rounded-full text-[11px] font-display font-bold bg-black-bean/85 text-champagne backdrop-blur-xs">
                {{ $carro->ano }}
            </span>
        </div>

        <!-- Top Right Favorite Button (like interface.jpg heart icon) -->
        <button type="button"
                @click="liked = !liked"
                :class="liked ? 'bg-fire-red text-white border-fire-red' : 'bg-white/90 text-black-bean hover:text-fire-red border-black-bean/10'"
                class="absolute top-3 right-3 w-8 h-8 rounded-full border backdrop-blur-xs flex items-center justify-center shadow-xs transition-colors cursor-pointer"
                title="Favoritar veículo">
            <x-icon name="heart" class="w-4 h-4" />
        </button>
    </div>

    <!-- Card Body -->
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            <!-- Category / Brand & Color -->
            <div class="flex items-center justify-between text-xs text-black-bean-500 font-medium mb-1">
                <span class="uppercase tracking-wider font-display font-bold text-fire-red">{{ $carro->marca }}</span>
                <span>{{ $carro->cor }} • {{ $carro->quantidade_disponivel }} un.</span>
            </div>

            <!-- Model & Version -->
            <a href="{{ route('carros.show', $carro) }}" class="block group-hover:text-fire-red transition-colors">
                <h3 class="font-display font-bold text-lg text-black-bean leading-snug truncate">
                    {{ $carro->modelo }}
                </h3>
                <p class="text-xs text-black-bean-500 truncate mt-0.5">{{ $carro->versao }}</p>
            </a>

            <!-- Specs Row (matching 3 icons row in interface.jpg) -->
            <div class="grid grid-cols-3 gap-2 mt-4 pt-3.5 border-t border-black-bean/10 text-[11px] text-black-bean-600 font-medium">
                <div class="flex items-center gap-1.5 truncate" title="Quilometragem">
                    <x-icon name="gauge" class="w-3.5 h-3.5 text-fire-red" />
                    <span class="truncate">{{ number_format($carro->quilometragem, 0, ',', '.') }} km</span>
                </div>
                <div class="flex items-center gap-1.5 truncate" title="Câmbio">
                    <x-icon name="settings-2" class="w-3.5 h-3.5 text-fire-red" />
                    <span class="truncate">{{ $carro->cambio }}</span>
                </div>
                <div class="flex items-center gap-1.5 truncate" title="Combustível">
                    <x-icon name="fuel" class="w-3.5 h-3.5 text-fire-red" />
                    <span class="truncate">{{ $carro->combustivel }}</span>
                </div>
            </div>
        </div>

        <!-- Price & CTA Row (matching bottom of card in interface.jpg) -->
        <div class="mt-5 pt-4 border-t border-black-bean/10">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <span class="block text-[10px] uppercase tracking-wider text-black-bean-400 font-semibold">Valor à vista</span>
                    <div class="font-display font-extrabold text-lg text-fire-red leading-tight">
                        R$ {{ number_format($carro->preco, 2, ',', '.') }}
                    </div>
                </div>

                @if ($carro->isDisponivel())
                    <form action="{{ route('carrinho.adicionar', $carro) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantidade" value="1">
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg border border-black-bean/20 bg-white hover:bg-black-bean text-black-bean hover:text-white text-xs font-display font-bold uppercase tracking-wider transition-all cursor-pointer">
                            <span>Comprar</span>
                        </button>
                    </form>
                @else
                    <span class="px-3 py-1.5 rounded-lg bg-black-bean-50 text-black-bean-400 text-xs font-display font-bold uppercase">
                        Indisponível
                    </span>
                @endif
            </div>

            <!-- Action Links Row -->
            <div class="mt-3 pt-2.5 border-t border-dashed border-black-bean/10 flex items-center justify-between text-xs">
                <a href="{{ route('carros.show', $carro) }}" class="inline-flex items-center gap-1 font-display font-semibold text-black-bean-700 hover:text-fire-red transition-colors">
                    <x-icon name="eye" class="w-3.5 h-3.5 text-fire-red" />
                    <span>Ver Detalhes</span>
                </a>

                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ route('carros.edit', $carro) }}" class="inline-flex items-center gap-1 text-black-bean-600 hover:text-black-bean font-medium">
                            <x-icon name="pencil" class="w-3.5 h-3.5" />
                            <span>Editar</span>
                        </a>
                        <form action="{{ route('carros.destroy', $carro) }}" method="POST" class="inline" onsubmit="return confirm('Deseja excluir este veículo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-fire-red hover:text-fire-red-800 font-medium cursor-pointer">
                                <x-icon name="trash-2" class="w-3.5 h-3.5" />
                                <span>Excluir</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</article>
