@extends('layouts.app')

@section('conteudo')
<h2>Lista de Usuarios Cadastrados</h2>

<p><a href="{{ route('usuarios.create') }}">Cadastrar Novo Usuario</a></p>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Cidade/UF</th>
            <th>Acoes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->cpf }}</td>
                <td>{{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : '-' }}</td>
                <td>{{ $usuario->e_mail }}</td>
                <td>{{ $usuario->telefone }}</td>
                <td>{{ $usuario->cidade }}/{{ $usuario->estado }}</td>
                <td>
                    <a href="{{ route('usuarios.show', $usuario) }}">Ver</a> |
                    <a href="{{ route('usuarios.edit', $usuario) }}">Editar</a> |
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Deseja realmente excluir este usuario?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
