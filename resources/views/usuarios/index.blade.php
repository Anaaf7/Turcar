@extends('layouts.app')

@section('titulo', 'Lista de Usuários — Turcar Concessionária')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="ADMINISTRAÇÃO"
        title="Lista de Usuários Cadastrados"
        description="Gerencie os clientes e administradores cadastrados na plataforma Turcar.">
        <x-slot:actions>
            <x-button variant="primary" :href="route('usuarios.create')" icon="user-plus">
                Cadastrar Novo Usuário
            </x-button>
        </x-slot:actions>
    </x-section-header>

    <div class="bg-white rounded-3xl border border-black-bean/10 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-black-bean text-champagne font-display text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-5">ID</th>
                        <th class="py-3.5 px-5">Usuário</th>
                        <th class="py-3.5 px-5">CPF</th>
                        <th class="py-3.5 px-5">Nascimento</th>
                        <th class="py-3.5 px-5">Contato</th>
                        <th class="py-3.5 px-5">Cidade / UF</th>
                        <th class="py-3.5 px-5 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black-bean/10">
                    @foreach ($usuarios as $usuario)
                        <tr class="hover:bg-surface/80 transition-colors">
                            <td class="py-4 px-5 font-display font-bold text-black-bean-400">#{{ $usuario->id }}</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-champagne-200 text-black-bean font-display font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($usuario->nome, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="font-display font-bold text-black-bean hover:text-fire-red transition-colors">
                                            {{ $usuario->nome }}
                                        </a>
                                        <p class="text-xs text-black-bean-500">{{ $usuario->e_mail }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-5 font-mono text-xs text-black-bean-700">{{ $usuario->cpf }}</td>
                            <td class="py-4 px-5">
                                {{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-4 px-5 text-xs text-black-bean-600">{{ $usuario->telefone }}</td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full bg-champagne-100 text-black-bean text-xs font-medium">
                                    {{ $usuario->cidade }}/{{ $usuario->estado }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('usuarios.show', $usuario) }}"
                                       class="px-2.5 py-1.5 rounded-lg bg-surface hover:bg-champagne-200 text-black-bean text-xs font-display font-semibold transition-colors">
                                        Ver
                                    </a>
                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                       class="px-2.5 py-1.5 rounded-lg bg-surface hover:bg-champagne-200 text-black-bean text-xs font-display font-semibold transition-colors">
                                        Editar
                                    </a>
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-fire-red-50 hover:bg-fire-red text-fire-red hover:text-white text-xs font-display font-semibold transition-colors cursor-pointer">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
