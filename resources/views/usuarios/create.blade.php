@extends('layouts.app')

@section('titulo', 'Cadastrar Novo Usuário — Turcar Concessionária')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="GESTÃO DE CLIENTES"
        title="Cadastrar Novo Usuário"
        actionText="Voltar para Usuários"
        :actionHref="route('usuarios.index')" />

    <div class="bg-white rounded-3xl border border-black-bean/10 shadow-xs p-8">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <x-user-form submitLabel="Salvar Usuário" :cancelHref="route('usuarios.index')" />
        </form>
    </div>
</div>
@endsection
