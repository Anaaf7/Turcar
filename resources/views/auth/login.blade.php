@extends('layouts.app')

@section('titulo', 'Entrar no Sistema — Turcar Concessionária')

@section('conteudo')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl border border-black-bean/10 shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        <!-- Left Automotive Brand Panel -->
        <div class="lg:col-span-5 bg-black-bean text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=900&q=80"
                 alt="Turcar Login"
                 class="absolute inset-0 w-full h-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-t from-black-bean via-black-bean/85 to-black-bean/60"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-fire-red flex items-center justify-center text-white">
                        <x-icon name="gauge" class="w-5 h-5" />
                    </div>
                    <span class="font-display font-extrabold text-xl tracking-tight">
                        Tur<span class="text-fire-red">Car</span>
                    </span>
                </div>

                <h3 class="font-display font-extrabold text-2xl sm:text-3xl mt-8 leading-tight">
                    Bem-vindo de volta ao Showroom
                </h3>
                <p class="text-xs text-champagne/80 mt-2 leading-relaxed">
                    Acesse sua conta para gerenciar seu carrinho, simular financiamentos e reservar veículos com segurança.
                </p>
            </div>

            <div class="relative z-10 pt-8 space-y-2.5 text-xs text-champagne/85">
                <div class="flex items-center gap-2">
                    <x-icon name="shield-check" class="w-4 h-4 text-fire-red" />
                    <span>Ambiente 100% seguro</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-icon name="badge-percent" class="w-4 h-4 text-fire-red" />
                    <span>Simulação de parcelas em até 60x</span>
                </div>
            </div>
        </div>

        <!-- Right Login Form -->
        <div class="lg:col-span-7 p-8 sm:p-12" x-data="{ showSenha: false }">
            <div class="mb-7">
                <span class="text-xs font-display font-bold uppercase tracking-widest text-fire-red">Acesso do Cliente</span>
                <h2 class="font-display font-bold text-2xl text-black-bean mt-1">Entrar no Sistema</h2>
                <p class="text-xs text-black-bean-500 mt-1">Informe seu e-mail e senha cadastrados para continuar.</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <x-input label="E-mail" name="e_mail" type="email" :value="old('e_mail')" placeholder="seu@email.com" icon="mail" required />

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="senha" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700">
                            Senha
                        </label>
                        <button type="button" @click="showSenha = !showSenha" class="text-xs font-medium text-black-bean-500 hover:text-fire-red inline-flex items-center gap-1 cursor-pointer">
                            <x-icon name="eye" class="w-3.5 h-3.5" />
                            <span x-text="showSenha ? 'Ocultar' : 'Mostrar'"></span>
                        </button>
                    </div>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 pl-3.5 flex items-center text-fire-red">
                            <x-icon name="lock" class="w-4 h-4" />
                        </div>
                        <input :type="showSenha ? 'text' : 'password'"
                               id="senha"
                               name="senha"
                               placeholder="Digite sua senha"
                               required
                               class="w-full rounded-xl border border-black-bean/15 bg-white text-sm text-black-bean pl-10 pr-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-fire-red/20 focus:border-fire-red">
                    </div>
                </div>

                <x-button type="submit" variant="primary" size="lg" class="w-full" icon="log-in">
                    Entrar
                </x-button>
            </form>

            <p class="text-xs text-center text-black-bean-600 mt-6 pt-6 border-t border-black-bean/10">
                Ainda não tem conta?
                <a href="{{ route('register') }}" class="font-display font-bold text-fire-red hover:underline ml-1">
                    Cadastre-se aqui
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection
