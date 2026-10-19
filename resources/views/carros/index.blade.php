@extends('layouts.app')

@section('conteudo')
<h2>Catalogo de Veiculos</h2>

<fieldset>
    <legend>Filtros e Busca de Veiculos</legend>
    <form action="{{ route('carros.index') }}" method="GET">
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="{{ request('marca') }}">

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="{{ request('modelo') }}">

        <label for="ano">Ano:</label>
        <input type="number" id="ano" name="ano" value="{{ request('ano') }}">

        <label for="preco_min">Preco Minimo:</label>
        <input type="number" step="0.01" id="preco_min" name="preco_min" value="{{ request('preco_min') }}">

        <label for="preco_max">Preco Maximo:</label>
        <input type="number" step="0.01" id="preco_max" name="preco_max" value="{{ request('preco_max') }}">

        <label for="combustivel">Combustivel:</label>
        <select id="combustivel" name="combustivel">
            <option value="">Todos</option>
            @foreach ($combustiveis as $comb)
                <option value="{{ $comb }}" {{ request('combustivel') == $comb ? 'selected' : '' }}>{{ $comb }}</option>
            @endforeach
        </select>

        <label for="cambio">Cambio:</label>
        <select id="cambio" name="cambio">
            <option value="">Todos</option>
            @foreach ($cambios as $cam)
                <option value="{{ $cam }}" {{ request('cambio') == $cam ? 'selected' : '' }}>{{ $cam }}</option>
            @endforeach
        </select>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="">Todos</option>
            <option value="disponivel" {{ request('status') == 'disponivel' ? 'selected' : '' }}>Disponivel</option>
            <option value="vendido" {{ request('status') == 'vendido' ? 'selected' : '' }}>Vendido</option>
            <option value="reservado" {{ request('status') == 'reservado' ? 'selected' : '' }}>Reservado</option>
        </select>

        <button type="submit">Buscar</button>
        <a href="{{ route('carros.index') }}">Limpar Filtros</a>
    </form>
</fieldset>

<br>

@if ($carros->isEmpty())
    <p>Nenhum veiculo encontrado com os criterios selecionados.</p>
@else
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Versao</th>
                <th>Ano</th>
                <th>Preco</th>
                <th>Km</th>
                <th>Combustivel</th>
                <th>Cambio</th>
                <th>Estoque</th>
                <th>Status</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carros as $carro)
                <tr>
                    <td>{{ $carro->id }}</td>
                    <td>
                        <img src="{{ $carro->imagem }}" alt="{{ $carro->modelo }}" width="120">
                    </td>
                    <td>{{ $carro->marca }}</td>
                    <td>{{ $carro->modelo }}</td>
                    <td>{{ $carro->versao }}</td>
                    <td>{{ $carro->ano }}</td>
                    <td>R$ {{ number_format($carro->preco, 2, ',', '.') }}</td>
                    <td>{{ number_format($carro->quilometragem, 0, ',', '.') }} km</td>
                    <td>{{ $carro->combustivel }}</td>
                    <td>{{ $carro->cambio }}</td>
                    <td>{{ $carro->quantidade_disponivel }}</td>
                    <td>{{ $carro->status }}</td>
                    <td>
                        <a href="{{ route('carros.show', $carro) }}">Ver Detalhes</a>
                        <br><br>
                        @if ($carro->isDisponivel())
                            <form action="{{ route('carrinho.adicionar', $carro) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantidade" value="1">
                                <button type="submit">Adicionar ao Carrinho</button>
                            </form>
                        @else
                            <span>Indisponivel</span>
                        @endif

                        @auth
                            <br>
                            <a href="{{ route('carros.edit', $carro) }}">Editar</a>
                            <form action="{{ route('carros.destroy', $carro) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Deseja excluir este veiculo?')">Excluir</button>
                            </form>
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
