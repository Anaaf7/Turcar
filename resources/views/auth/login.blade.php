@extends('layouts.app')

@section('conteudo')
<h2>Entrar no Sistema</h2>

<form action="{{ route('login.post') }}" method="POST">
    @csrf

    <div>
        <label for="e_mail">E-mail:</label><br>
        <input type="email" id="e_mail" name="e_mail" value="{{ old('e_mail') }}" required>
    </div>
    <br>

    <div>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required>
    </div>
    <br>

    <div>
        <button type="submit">Entrar</button>
    </div>
</form>

<p>Ainda nao tem conta? <a href="{{ route('register') }}">Cadastre-se aqui</a>.</p>
@endsection
