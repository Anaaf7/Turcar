@extends('layouts.app')

@section('conteudo')
<h2>Editar Usuario: {{ $usuario->nome }}</h2>

<form action="{{ route('usuarios.update', $usuario) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="nome">Nome Completo:</label><br>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required>
    </div>
    <br>

    <div>
        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $usuario->cpf) }}" required>
    </div>
    <br>

    <div>
        <label for="data_nascimento">Data de Nascimento (Obrigatorio maior de 18 anos):</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $usuario->data_nascimento ? $usuario->data_nascimento->format('Y-m-d') : '') }}" required>
    </div>
    <br>

    <div>
        <label for="e_mail">E-mail:</label><br>
        <input type="email" id="e_mail" name="e_mail" value="{{ old('e_mail', $usuario->e_mail) }}" required>
    </div>
    <br>

    <div>
        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $usuario->telefone) }}" required>
    </div>
    <br>

    <div>
        <label for="endereco">Endereco:</label><br>
        <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $usuario->endereco) }}" required>
    </div>
    <br>

    <div>
        <label for="numero">Numero:</label><br>
        <input type="text" id="numero" name="numero" value="{{ old('numero', $usuario->numero) }}" required>
    </div>
    <br>

    <div>
        <label for="cidade">Cidade:</label><br>
        <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $usuario->cidade) }}" required>
    </div>
    <br>

    <div>
        <label for="estado">Estado (UF):</label><br>
        <input type="text" id="estado" name="estado" value="{{ old('estado', $usuario->estado) }}" required>
    </div>
    <br>

    <div>
        <label for="senha">Nova Senha (deixe em branco para manter a atual):</label><br>
        <input type="password" id="senha" name="senha">
    </div>
    <br>

    <div>
        <label for="senha_confirmation">Confirmar Nova Senha:</label><br>
        <input type="password" id="senha_confirmation" name="senha_confirmation">
    </div>
    <br>

    <div>
        <button type="submit">Atualizar Dados</button>
        <a href="{{ route('usuarios.show', $usuario) }}">Cancelar</a>
    </div>
</form>
@endsection
