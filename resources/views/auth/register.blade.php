@extends('layouts.app')

@section('conteudo')
<h2>Cadastro de Usuario</h2>

<form action="{{ route('register.post') }}" method="POST">
    @csrf

    <div>
        <label for="nome">Nome Completo:</label><br>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
    </div>
    <br>

    <div>
        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
    </div>
    <br>

    <div>
        <label for="data_nascimento">Data de Nascimento (Obrigatorio maior de 18 anos):</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
    </div>
    <br>

    <div>
        <label for="e_mail">E-mail:</label><br>
        <input type="email" id="e_mail" name="e_mail" value="{{ old('e_mail') }}" required>
    </div>
    <br>

    <div>
        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
    </div>
    <br>

    <div>
        <label for="endereco">Endereco:</label><br>
        <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required>
    </div>
    <br>

    <div>
        <label for="numero">Numero:</label><br>
        <input type="text" id="numero" name="numero" value="{{ old('numero') }}" required>
    </div>
    <br>

    <div>
        <label for="cidade">Cidade:</label><br>
        <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
    </div>
    <br>

    <div>
        <label for="estado">Estado (UF):</label><br>
        <input type="text" id="estado" name="estado" value="{{ old('estado') }}" required>
    </div>
    <br>

    <div>
        <label for="senha">Senha (minimo 8 caracteres):</label><br>
        <input type="password" id="senha" name="senha" required>
    </div>
    <br>

    <div>
        <label for="senha_confirmation">Confirmacao de Senha:</label><br>
        <input type="password" id="senha_confirmation" name="senha_confirmation" required>
    </div>
    <br>

    <div>
        <button type="submit">Cadastrar</button>
    </div>
</form>

<p>Ja possui uma conta? <a href="{{ route('login') }}">Faca login aqui</a>.</p>
@endsection
