@extends('layouts.app')

@section('conteudo')
<h2>Meu Carrinho de Compras</h2>

@if ($itens->isEmpty())
    <p>Seu carrinho de compras esta vazio.</p>
    <p><a href="{{ route('carros.index') }}">Continuar visualizando o catalogo de veiculos</a></p>
@else
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Veiculo</th>
                <th>Preco Unitario</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Acao</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itens as $item)
                <tr>
                    <td>
                        @if ($item->carro)
                            <img src="{{ $item->carro->imagem }}" alt="{{ $item->carro->modelo }}" width="100">
                        @endif
                    </td>
                    <td>
                        @if ($item->carro)
                            <strong>{{ $item->carro->marca }} {{ $item->carro->modelo }}</strong><br>
                            <span>{{ $item->carro->versao }} ({{ $item->carro->ano }})</span>
                        @else
                            <span>Veiculo nao encontrado</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->carro)
                            R$ {{ number_format($item->carro->preco, 2, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('carrinho.atualizar', $item) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1" max="{{ $item->carro ? $item->carro->quantidade_disponivel : 1 }}" style="width: 60px;">
                            <button type="submit">Atualizar</button>
                        </form>
                    </td>
                    <td>
                        <strong>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</strong>
                    </td>
                    <td>
                        <form action="{{ route('carrinho.remover', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Remover este item do carrinho?')">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" align="right">Valor Total do Carrinho:</th>
                <th colspan="2" align="left">R$ {{ number_format($total, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <br>

    <form action="{{ route('carrinho.limpar') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" onclick="return confirm('Tem certeza que deseja esvaziar todo o carrinho?')">Limpar Todo o Carrinho</button>
    </form>
    |
    <a href="{{ route('carros.index') }}">Continuar Comprando</a>

    <hr>

    <h3>Simulacao de Financiamento e Parcelamento do Carrinho</h3>
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

    <hr>

    <h3>Finalizar Compra</h3>
    <form action="{{ route('carrinho.finalizar') }}" method="POST">
        @csrf

        <div>
            <label for="metodo">Forma de Pagamento:</label><br>
            <select id="metodo" name="metodo" required>
                <option value="a_vista">Pagamento a Vista (TED / PIX)</option>
                <option value="financiamento">Financiamento Bancario</option>
                <option value="cartao_credito">Cartao de Credito</option>
            </select>
        </div>
        <br>

        <div>
            <label for="parcelas">Condicao de Parcelamento:</label><br>
            <select id="parcelas" name="parcelas">
                <option value="1">1x a Vista - R$ {{ number_format($total, 2, ',', '.') }}</option>
                @foreach ($simulacoes as $sim)
                    <option value="{{ $sim['parcelas'] }}">
                        {{ $sim['parcelas'] }}x de R$ {{ number_format($sim['valor_parcela'], 2, ',', '.') }} (Total: R$ {{ number_format($sim['total_com_juros'], 2, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>
        <br>

        <div>
            <button type="submit" onclick="return confirm('Confirma a finalizacao da compra?')">Confirmar e Finalizar Compra</button>
        </div>
    </form>
@endif
@endsection
