@extends('layouts.app')

@section('conteudo')
<h2>Detalhes do Veiculo: {{ $carro->marca }} {{ $carro->modelo }} {{ $carro->versao }}</h2>

<div>
    <img src="{{ $carro->imagem }}" alt="{{ $carro->modelo }}" width="350">
</div>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Marca</th>
        <td>{{ $carro->marca }}</td>
    </tr>
    <tr>
        <th>Modelo</th>
        <td>{{ $carro->modelo }}</td>
    </tr>
    <tr>
        <th>Versao</th>
        <td>{{ $carro->versao }}</td>
    </tr>
    <tr>
        <th>Ano Fabricacao/Modelo</th>
        <td>{{ $carro->ano }}</td>
    </tr>
    <tr>
        <th>Preco</th>
        <td><strong>R$ {{ number_format($carro->preco, 2, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <th>Quilometragem</th>
        <td>{{ number_format($carro->quilometragem, 0, ',', '.') }} km</td>
    </tr>
    <tr>
        <th>Cor</th>
        <td>{{ $carro->cor }}</td>
    </tr>
    <tr>
        <th>Combustivel</th>
        <td>{{ $carro->combustivel }}</td>
    </tr>
    <tr>
        <th>Cambio</th>
        <td>{{ $carro->cambio }}</td>
    </tr>
    <tr>
        <th>Numero de Portas</th>
        <td>{{ $carro->numero_portas }}</td>
    </tr>
    <tr>
        <th>Quantidade Disponivel</th>
        <td>{{ $carro->quantidade_disponivel }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $carro->status }}</td>
    </tr>
    <tr>
        <th>Descricao</th>
        <td>{{ $carro->descricao }}</td>
    </tr>
</table>

<br>

@if ($carro->isDisponivel())
    <form action="{{ route('carrinho.adicionar', $carro) }}" method="POST">
        @csrf
        <label for="quantidade">Quantidade desejada:</label>
        <input type="number" id="quantidade" name="quantidade" value="1" min="1" max="{{ $carro->quantidade_disponivel }}" required>
        <button type="submit">Adicionar ao Carrinho</button>
    </form>
@else
    <p><strong>Veiculo indisponivel no momento.</strong></p>
@endif

<br>

<h3>Simulacao de Parcelamento e Financiamento</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Prazo</th>
            <th>Taxa Mensal</th>
            <th>Valor da Parcela</th>
            <th>Total com Juros</th>
            <th>Total de Juros</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($simulacoes as $sim)
            <tr>
                <td>{{ $sim['parcelas'] }}x</td>
                <td>{{ $sim['taxa_mensal'] }}% a.m.</td>
                <td>R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($sim['total_juros'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>
<p>
    <a href="{{ route('carros.index') }}">Voltar para o Catalogo</a>
    @auth
        | <a href="{{ route('carros.edit', $carro) }}">Editar este Veiculo</a>
    @endauth
</p>
@endsection
