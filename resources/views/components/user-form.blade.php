@props([
    'usuario' => null,
    'isEdit' => false,
    'submitLabel' => 'Salvar Usuário',
    'cancelHref' => null,
])

<div x-data="{ showPass: false }" class="space-y-6">
    <!-- Dados Pessoais -->
    <div>
        <h3 class="font-display font-bold text-sm uppercase tracking-wider text-fire-red mb-4 flex items-center gap-2">
            <x-icon name="user-check" class="w-4 h-4" />
            <span>Dados Pessoais</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <x-input label="Nome Completo" name="nome" :value="old('nome', $usuario?->nome)" placeholder="Digite seu nome completo" icon="user" required />
            </div>
            <x-input label="CPF" name="cpf" :value="old('cpf', $usuario?->cpf)" placeholder="000.000.000-00" icon="id-card" required />
            <x-input label="Data de Nascimento (+18 anos)" name="data_nascimento" type="date" :value="old('data_nascimento', $usuario?->data_nascimento ? $usuario->data_nascimento->format('Y-m-d') : '')" icon="calendar" hint="Obrigatório ser maior de 18 anos." required />
        </div>
    </div>

    <!-- Contato -->
    <div class="pt-4 border-t border-black-bean/10">
        <h3 class="font-display font-bold text-sm uppercase tracking-wider text-fire-red mb-4 flex items-center gap-2">
            <x-icon name="phone" class="w-4 h-4" />
            <span>Contato & Acesso</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="E-mail" name="e_mail" type="email" :value="old('e_mail', $usuario?->e_mail)" placeholder="seu@email.com" icon="mail" required />
            <x-input label="Telefone / WhatsApp" name="telefone" :value="old('telefone', $usuario?->telefone)" placeholder="(11) 99999-9999" icon="smartphone" required />
        </div>
    </div>

    <!-- Endereço -->
    <div class="pt-4 border-t border-black-bean/10">
        <h3 class="font-display font-bold text-sm uppercase tracking-wider text-fire-red mb-4 flex items-center gap-2">
            <x-icon name="map-pin" class="w-4 h-4" />
            <span>Endereço</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-3">
                <x-input label="Logradouro / Endereço" name="endereco" :value="old('endereco', $usuario?->endereco)" placeholder="Rua, Avenida..." icon="map" required />
            </div>
            <x-input label="Número" name="numero" :value="old('numero', $usuario?->numero)" placeholder="123" icon="hash" required />
            <div class="sm:col-span-3">
                <x-input label="Cidade" name="cidade" :value="old('cidade', $usuario?->cidade)" placeholder="Ex: São Paulo" icon="building-2" required />
            </div>
            <x-input label="Estado (UF)" name="estado" :value="old('estado', $usuario?->estado)" placeholder="SP" maxlength="2" required />
        </div>
    </div>

    <!-- Segurança / Senha -->
    <div class="pt-4 border-t border-black-bean/10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display font-bold text-sm uppercase tracking-wider text-fire-red flex items-center gap-2">
                <x-icon name="lock" class="w-4 h-4" />
                <span>Segurança</span>
            </h3>
            <button type="button" @click="showPass = !showPass" class="text-xs font-display font-semibold text-black-bean-600 hover:text-fire-red inline-flex items-center gap-1 cursor-pointer">
                <x-icon name="eye" class="w-3.5 h-3.5" />
                <span x-text="showPass ? 'Ocultar senhas' : 'Mostrar senhas'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="senha" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-1.5">
                    {{ $isEdit ? 'Nova Senha (opcional)' : 'Senha (mínimo 8 caracteres)' }}
                </label>
                <input :type="showPass ? 'text' : 'password'"
                       id="senha"
                       name="senha"
                       placeholder="{{ $isEdit ? 'Deixe em branco para manter a atual' : 'Mínimo de 8 caracteres' }}"
                       {{ $isEdit ? '' : 'required' }}
                       class="w-full rounded-xl border border-black-bean/15 bg-white text-sm text-black-bean px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-fire-red/20 focus:border-fire-red">
                @error('senha')
                    <p class="mt-1 text-xs font-medium text-fire-red">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="senha_confirmation" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-1.5">
                    {{ $isEdit ? 'Confirmar Nova Senha' : 'Confirmação de Senha' }}
                </label>
                <input :type="showPass ? 'text' : 'password'"
                       id="senha_confirmation"
                       name="senha_confirmation"
                       placeholder="Repita a senha"
                       {{ $isEdit ? '' : 'required' }}
                       class="w-full rounded-xl border border-black-bean/15 bg-white text-sm text-black-bean px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-fire-red/20 focus:border-fire-red">
            </div>
        </div>
    </div>

    <div class="pt-4 border-t border-black-bean/10 flex items-center justify-end gap-3">
        @if ($cancelHref)
            <x-button variant="outline" :href="$cancelHref" icon="x">Cancelar</x-button>
        @endif
        <x-button type="submit" variant="primary" icon="check">
            {{ $submitLabel }}
        </x-button>
    </div>
</div>
