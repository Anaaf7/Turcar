@extends('layouts.app')

@section('titulo', 'Editar Veículo — Turcar Concessionária')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-section-header
        subtitle="ATUALIZAR REGISTRO"
        :title="'Editar Veículo: ' . $carro->marca . ' ' . $carro->modelo"
        description="Atualize preço, estoque, status ou dados técnicos deste veículo."
        actionText="Ver Página do Veículo"
        :actionHref="route('carros.show', $carro)" />

    <form action="{{ route('carros.update', $carro) }}" method="POST">
        @csrf
        @method('PUT')
        <x-car-form :carro="$carro" submitLabel="Salvar Alterações" :cancelHref="route('carros.show', $carro)" />
    </form>
</div>
@endsection
