@extends('layouts.app')

@section('conteudo')
<h2>Editar Veiculo: {{ $carro->marca }} {{ $carro->modelo }}</h2>

<form action="{{ route('carros.update', $carro) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="marca">Marca:</label><br>
        <input type="text" id="marca" name="marca" value="{{ old('marca', $carro->marca) }}" required>
    </div>
    <br>

    <div>
        <label for="modelo">Modelo:</label><br>
        <input type="text" id="modelo" name="modelo" value="{{ old('modelo', $carro->modelo) }}" required>
    </div>
    <br>

    <div>
        <label for="versao">Versao:</label><br>
        <input type="text" id="versao" name="versao" value="{{ old('versao', $carro->versao) }}" required>
    </div>
    <br>

    <div>
        <label for="ano">Ano:</label><br>
        <input type="number" id="ano" name="ano" value="{{ old('ano', $carro->ano) }}" required>
    </div>
    <br>

    <div>
        <label for="preco">Preco (R$):</label><br>
        <input type="number" step="0.01" id="preco" name="preco" value="{{ old('preco', $carro->preco) }}" required>
    </div>
    <br>

    <div>
        <label for="quilometragem">Quilometragem (km):</label><br>
        <input type="number" id="quilometragem" name="quilometragem" value="{{ old('quilometragem', $carro->quilometragem) }}" required>
    </div>
    <br>

    <div>
        <label for="cor">Cor:</label><br>
        <input type="text" id="cor" name="cor" value="{{ old('cor', $carro->cor) }}" required>
    </div>
    <br>

    <div>
        <label for="combustivel">Combustivel:</label><br>
        <select id="combustivel" name="combustivel" required>
            <option value="Flex" {{ old('combustivel', $carro->combustivel) == 'Flex' ? 'selected' : '' }}>Flex</option>
            <option value="Gasolina" {{ old('combustivel', $carro->combustivel) == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
            <option value="Etanol" {{ old('combustivel', $carro->combustivel) == 'Etanol' ? 'selected' : '' }}>Etanol</option>
            <option value="Diesel" {{ old('combustivel', $carro->combustivel) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
            <option value="Eletrico" {{ old('combustivel', $carro->combustivel) == 'Eletrico' ? 'selected' : '' }}>Eletrico</option>
            <option value="Hibrido" {{ old('combustivel', $carro->combustivel) == 'Hibrido' ? 'selected' : '' }}>Hibrido</option>
        </select>
    </div>
    <br>

    <div>
        <label for="cambio">Cambio:</label><br>
        <select id="cambio" name="cambio" required>
            <option value="Manual" {{ old('cambio', $carro->cambio) == 'Manual' ? 'selected' : '' }}>Manual</option>
            <option value="Automático" {{ old('cambio', $carro->cambio) == 'Automático' ? 'selected' : '' }}>Automático</option>
            <option value="CVT" {{ old('cambio', $carro->cambio) == 'CVT' ? 'selected' : '' }}>CVT</option>
            <option value="Automatizado" {{ old('cambio', $carro->cambio) == 'Automatizado' ? 'selected' : '' }}>Automatizado</option>
        </select>
    </div>
    <br>

    <div>
        <label for="numero_portas">Numero de Portas:</label><br>
        <input type="number" id="numero_portas" name="numero_portas" value="{{ old('numero_portas', $carro->numero_portas) }}" required>
    </div>
    <br>

    <div>
        <label for="descricao">Descricao:</label><br>
        <textarea id="descricao" name="descricao" rows="4" cols="50" required>{{ old('descricao', $carro->descricao) }}</textarea>
    </div>
    <br>

    <div>
        <label for="imagem">URL da Imagem:</label><br>
        <input type="text" id="imagem" name="imagem" size="60" value="{{ old('imagem', $carro->imagem) }}" required>
    </div>
    <br>

    <div>
        <label for="quantidade_disponivel">Quantidade Disponivel:</label><br>
        <input type="number" id="quantidade_disponivel" name="quantidade_disponivel" value="{{ old('quantidade_disponivel', $carro->quantidade_disponivel) }}" required>
    </div>
    <br>

    <div>
        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="disponivel" {{ old('status', $carro->status) == 'disponivel' ? 'selected' : '' }}>Disponivel</option>
            <option value="vendido" {{ old('status', $carro->status) == 'vendido' ? 'selected' : '' }}>Vendido</option>
            <option value="reservado" {{ old('status', $carro->status) == 'reservado' ? 'selected' : '' }}>Reservado</option>
        </select>
    </div>
    <br>

    <div>
        <button type="submit">Salvar Alteracoes</button>
        <a href="{{ route('carros.show', $carro) }}">Cancelar</a>
    </div>
</form>
@endsection
