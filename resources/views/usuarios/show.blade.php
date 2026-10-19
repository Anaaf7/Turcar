@extends('layouts.app')

@section('titulo', 'Perfil do Usuário — Turcar Concessionária')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="PERFIL DO CLIENTE"
        :title="'Perfil do Usuário: ' . $usuario->nome"
        actionText="Voltar para a Lista de Usuários"
        :actionHref="route('usuarios.index')" />

    <div class="bg-white rounded-3xl border border-black-bean/10 shadow-sm overflow-hidden">
        <!-- Profile Header Banner -->
        <div class="bg-black-bean text-white p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-fire-red text-white font-display font-extrabold text-2xl flex items-center justify-center shadow-md">
                    {{ strtoupper(substr($usuario->nome, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-display font-extrabold text-xl text-white">{{ $usuario->nome }}</h3>
                    <p class="text-xs text-champagne/80 mt-0.5">{{ $usuario->e_mail }}</p>
                    <div class="mt-2">
                        <x-badge :variant="$usuario->isMaiorDeIdade() ? 'success' : 'danger'">
                            {{ $usuario->isMaiorDeIdade() ? 'Maior de idade (+18)' : 'Menor de idade' }}
                        </x-badge>
                    </div>
                </div>
            </div>

            <x-button variant="champagne" size="sm" :href="route('usuarios.edit', $usuario)" icon="pencil">
                Editar Dados
            </x-button>
        </div>

        <!-- Details Grid -->
        <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">ID do Registro</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">#{{ $usuario->id }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">CPF</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">{{ $usuario->cpf }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Data de Nascimento</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">
                    {{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : '-' }}
                </span>
            </div>

            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Telefone</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">{{ $usuario->telefone }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10 sm:col-span-2">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Endereço Completo</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">
                    {{ $usuario->endereco }}, {{ $usuario->numero }} — {{ $usuario->cidade }} / {{ $usuario->estado }}
                </span>
            </div>

            <div class="p-4 rounded-2xl bg-surface border border-black-bean/10 sm:col-span-2">
                <span class="text-[11px] uppercase tracking-wider text-black-bean-400 font-semibold block">Data de Cadastro</span>
                <span class="font-display font-bold text-sm text-black-bean mt-1 block">
                    {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : '-' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
