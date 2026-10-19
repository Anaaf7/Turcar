@props([
    'carro' => null,
    'submitLabel' => 'Salvar Veículo',
    'cancelHref' => route('carros.index'),
])

@php
    $combustivelAtual = old('combustivel', $carro?->combustivel ?? 'Flex');
    $cambioAtual = old('cambio', $carro?->cambio ?? 'Automático');
    $statusAtual = old('status', $carro?->status ?? 'disponivel');
@endphp

<div x-data="{
        imagemUrl: '{{ old('imagem', $carro?->imagem ?? '') }}',
        marca: '{{ old('marca', $carro?->marca ?? '') }}',
        modelo: '{{ old('modelo', $carro?->modelo ?? '') }}',
        versao: '{{ old('versao', $carro?->versao ?? '') }}',
        preco: '{{ old('preco', $carro?->preco ?? '') }}',
        ano: '{{ old('ano', $carro?->ano ?? date('Y')) }}'
    }"
    class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Left 2 Columns: Form Fields -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-black-bean/10 shadow-xs p-6 md:p-8 space-y-6">
        <div class="border-b border-black-bean/10 pb-4">
            <h3 class="font-display font-bold text-lg text-black-bean flex items-center gap-2">
                <x-icon name="car-front" class="w-5 h-5 text-fire-red" />
                <span>Identificação e Especificações do Veículo</span>
            </h3>
            <p class="text-xs text-black-bean-500 mt-0.5">Preencha os dados técnicos do veículo para exibição no catálogo.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <x-input label="Marca" name="marca" x-model="marca" :value="old('marca', $carro?->marca)" placeholder="Ex: Toyota, BMW, Honda" icon="award" required />
            <x-input label="Modelo" name="modelo" x-model="modelo" :value="old('modelo', $carro?->modelo)" placeholder="Ex: Corolla, Série 3, Civic" icon="car" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="sm:col-span-2">
                <x-input label="Versão" name="versao" x-model="versao" :value="old('versao', $carro?->versao)" placeholder="Ex: 2.0 XEi Flex Automático" icon="sparkles" required />
            </div>
            <x-input label="Ano" name="ano" type="number" x-model="ano" :value="old('ano', $carro?->ano ?? date('Y'))" icon="calendar" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <x-input label="Preço (R$)" name="preco" type="number" step="0.01" x-model="preco" :value="old('preco', $carro?->preco)" placeholder="150000.00" icon="dollar-sign" required />
            <x-input label="Quilometragem (km)" name="quilometragem" type="number" :value="old('quilometragem', $carro?->quilometragem ?? 0)" icon="gauge" required />
            <x-input label="Cor" name="cor" :value="old('cor', $carro?->cor)" placeholder="Ex: Branco Pérola" icon="palette" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <x-select label="Combustível" name="combustivel" icon="fuel" required>
                @foreach (['Flex', 'Gasolina', 'Etanol', 'Diesel', 'Eletrico', 'Hibrido'] as $opcaoComb)
                    <option value="{{ $opcaoComb }}" {{ $combustivelAtual == $opcaoComb ? 'selected' : '' }}>{{ $opcaoComb }}</option>
                @endforeach
            </x-select>

            <x-select label="Câmbio" name="cambio" icon="settings-2" required>
                @foreach (['Manual', 'Automático', 'CVT', 'Automatizado'] as $opcaoCam)
                    <option value="{{ $opcaoCam }}" {{ $cambioAtual == $opcaoCam ? 'selected' : '' }}>{{ $opcaoCam }}</option>
                @endforeach
            </x-select>

            <x-input label="Número de Portas" name="numero_portas" type="number" :value="old('numero_portas', $carro?->numero_portas ?? 4)" icon="door-open" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="sm:col-span-2">
                <x-input label="URL da Imagem" name="imagem" x-model="imagemUrl" :value="old('imagem', $carro?->imagem)" placeholder="https://..." icon="image" required />
            </div>
            <x-input label="Quantidade Disponível" name="quantidade_disponivel" type="number" :value="old('quantidade_disponivel', $carro?->quantidade_disponivel ?? 1)" icon="package" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <x-select label="Status no Estoque" name="status" icon="check-circle" required>
                <option value="disponivel" {{ $statusAtual == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                <option value="reservado" {{ $statusAtual == 'reservado' ? 'selected' : '' }}>Reservado</option>
                <option value="vendido" {{ $statusAtual == 'vendido' ? 'selected' : '' }}>Vendido</option>
            </x-select>
        </div>

        <x-textarea label="Descrição Completa do Veículo" name="descricao" rows="4" placeholder="Descreva opcionais, histórico de revisões e diferenciais do veículo..." required>{{ old('descricao', $carro?->descricao) }}</x-textarea>

        <div class="pt-4 border-t border-black-bean/10 flex flex-wrap items-center justify-end gap-3">
            <x-button variant="outline" :href="$cancelHref" icon="x">
                Cancelar
            </x-button>
            <x-button type="submit" variant="primary" icon="check">
                {{ $submitLabel }}
            </x-button>
        </div>
    </div>

    <!-- Right Column: Live Alpine.js Preview -->
    <div class="space-y-4">
        <div class="bg-black-bean text-champagne rounded-2xl p-6 shadow-md">
            <span class="text-[11px] font-display font-bold uppercase tracking-widest text-fire-red">Preview em Tempo Real</span>
            <h4 class="font-display font-bold text-lg text-white mt-1">Visualização do Card</h4>
            <p class="text-xs text-champagne/70 mt-1">Veja como o veículo aparecerá para os clientes no catálogo.</p>

            <div class="mt-5 bg-white text-black-bean rounded-xl overflow-hidden shadow-lg">
                <div class="aspect-[16/10] bg-champagne-100 relative overflow-hidden flex items-center justify-center">
                    <template x-if="imagemUrl">
                        <img :src="imagemUrl" alt="Preview" class="w-full h-full object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=80'">
                    </template>
                    <template x-if="!imagemUrl">
                        <div class="text-center p-4 text-black-bean-400">
                            <x-icon name="image" class="w-8 h-8 mx-auto mb-1 text-fire-red/60" />
                            <span class="text-xs">Insira a URL da imagem</span>
                        </div>
                    </template>
                    <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-full text-[10px] font-display font-bold bg-black-bean/85 text-champagne" x-text="ano || '{{ date('Y') }}'"></span>
                </div>
                <div class="p-4">
                    <p class="text-[11px] font-display font-bold uppercase tracking-wider text-fire-red" x-text="marca || 'Marca'"></p>
                    <h5 class="font-display font-bold text-base text-black-bean truncate" x-text="modelo || 'Modelo do Veículo'"></h5>
                    <p class="text-xs text-black-bean-500 truncate" x-text="versao || 'Versão'"></p>
                    <div class="mt-3 pt-3 border-t border-black-bean/10 flex items-center justify-between">
                        <span class="text-[10px] uppercase text-black-bean-400 font-semibold">Preço</span>
                        <span class="font-display font-extrabold text-base text-fire-red"
                              x-text="preco ? 'R$ ' + Number(preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : 'R$ 0,00'"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
