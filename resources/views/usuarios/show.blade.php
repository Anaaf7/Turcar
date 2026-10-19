@extends('layouts.app')

@section('conteudo')
<h2>Perfil do Usuario: {{ $usuario->nome }}</h2>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <td>{{ $usuario->id }}</td>
    </tr>
    <tr>
        <th>Nome</th>
        <td>{{ $usuario->nome }}</td>
    </tr>
    <tr>
        <th>CPF</th>
        <td>{{ $usuario->cpf }}</td>
    </tr>
    <tr>
        <th>Data de Nascimento</th>
        <td>
            {{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : '-' }}
            ({{ $usuario->isMaiorDeIdade() ? 'Maior de idade' : 'Menor de idade' }})
        </td>
    </tr>
    <tr>
        <th>E-mail</th>
        <td>{{ $usuario->e_mail }}</td>
    </tr>
    <tr>
        <th>Telefone</th>
        <td>{{ $usuario->telefone }}</td>
    </tr>
    <tr>
        <th>Endereco</th>
        <td>{{ $usuario->endereco }}, {{ $usuario->numero }}</td>
    </tr>
    <tr>
        <th>Cidade / UF</th>
        <td>{{ $usuario->cidade }} / {{ $usuario->estado }}</td>
    </tr>
    <tr>
        <th>Data de Cadastro</th>
        <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : '-' }}</td>
    </tr>
</table>

<br>
<p>
    <a href="{{ route('usuarios.edit', $usuario) }}">Editar Dados</a> |
    <a href="{{ route('usuarios.index') }}">Voltar para a Lista de Usuarios</a>
</p>
@endsection
