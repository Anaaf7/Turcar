@extends('layouts.app')

@section('titulo', 'Cadastrar Novo Veículo — Turcar Concessionária')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="GESTÃO DE ESTOQUE"
        title="Cadastrar Novo Veículo"
        description="Adicione um novo veículo ao catálogo da Turcar com especificações completas e foto."
        actionText="Voltar ao Catálogo"
        :actionHref="route('carros.index')" />

    <form action="{{ route('carros.store') }}" method="POST">
        @csrf
        <x-car-form submitLabel="Cadastrar Veículo" :cancelHref="route('carros.index')" />
    </form>
</div>
@endsection
