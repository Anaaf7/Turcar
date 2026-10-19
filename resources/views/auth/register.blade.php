@extends('layouts.app')

@section('titulo', 'Cadastro de Usuário — Turcar Concessionária')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-black-bean/10 shadow-lg overflow-hidden">
        <!-- Header Banner -->
        <div class="bg-black-bean text-white px-8 py-7 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-display font-bold uppercase tracking-widest text-fire-red">Criar Conta</span>
                <h2 class="font-display font-extrabold text-2xl mt-0.5">Cadastro de Usuário</h2>
                <p class="text-xs text-champagne/80 mt-1">Preencha seus dados para comprar e simular veículos na Turcar.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 text-champagne text-xs font-display font-semibold">
                <x-icon name="shield-alert" class="w-4 h-4 text-fire-red" />
                <span>Exclusivo para maiores de 18 anos</span>
            </span>
        </div>

        <div class="p-8 sm:p-10">
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <x-user-form submitLabel="Cadastrar" />
            </form>

            <p class="text-xs text-center text-black-bean-600 mt-6 pt-6 border-t border-black-bean/10">
                Já possui uma conta?
                <a href="{{ route('login') }}" class="font-display font-bold text-fire-red hover:underline ml-1">
                    Faça login aqui
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection
