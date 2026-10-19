@extends('layouts.app')

@section('titulo', 'Editar Usuário — Turcar Concessionária')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="ATUALIZAR PERFIL"
        :title="'Editar Usuário: ' . $usuario->nome"
        actionText="Voltar ao Perfil"
        :actionHref="route('usuarios.show', $usuario)" />

    <div class="bg-white rounded-3xl border border-black-bean/10 shadow-xs p-8">
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')
            <x-user-form :usuario="$usuario" :isEdit="true" submitLabel="Atualizar Dados" :cancelHref="route('usuarios.show', $usuario)" />
        </form>
    </div>
</div>
@endsection
