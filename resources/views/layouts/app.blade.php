<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Turcar Concessionaria</title>
</head>
<body>
    <header>
        <h1>Turcar Concessionaria de Veiculos</h1>
        <nav>
            <a href="{{ route('carros.index') }}">Catalogo de Carros</a> |
            <a href="{{ route('carrinho.index') }}">Carrinho</a> |
            @auth
                <a href="{{ route('carros.create') }}">Cadastrar Novo Carro</a> |
                <a href="{{ route('usuarios.index') }}">Listar Usuarios</a> |
                <a href="{{ route('usuarios.show', Auth::user()) }}">Meu Perfil ({{ Auth::user()->nome }})</a> |
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Sair (Logout)</button>
                </form>
            @else
                <a href="{{ route('login') }}">Entrar (Login)</a> |
                <a href="{{ route('register') }}">Cadastre-se</a>
            @endauth
        </nav>
        <hr>
    </header>

    <main>
        @if (session('sucesso'))
            <p><strong>Sucesso:</strong> {{ session('sucesso') }}</p>
            <hr>
        @endif

        @if (session('erro'))
            <p><strong>Erro:</strong> {{ session('erro') }}</p>
            <hr>
        @endif

        @if ($errors->any())
            <div>
                <strong>Erros de Validacao:</strong>
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
            <hr>
        @endif

        @yield('conteudo')
    </main>
</body>
</html>
