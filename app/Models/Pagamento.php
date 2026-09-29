<?php

namespace App\Models;

class Pagamento
{
    private float $taxaMensalPadrao;

    public function __construct(float $taxaMensalPadrao = 0.015)
    {
        $this->taxaMensalPadrao = $taxaMensalPadrao;
    }

    public function getTaxaMensalPadrao(): float
    {
        return $this->taxaMensalPadrao;
    }

    public function setTaxaMensalPadrao(float $taxa): void
    {
        $this->taxaMensalPadrao = $taxa;
    }

    public function calcularSubtotal(float $preco, int $quantidade): float
    {
        return $preco * $quantidade;
    }

    public function calcularTotal(iterable $itens): float
    {
        $total = 0.0;

        foreach ($itens as $item) {
            if ($item instanceof Carrinho) {
                $total += $item->calcularSubtotal();
            } elseif (is_array($item) && isset($item['preco'], $item['quantidade'])) {
                $total += $this->calcularSubtotal((float) $item['preco'], (int) $item['quantidade']);
            }
        }

        return $total;
    }

    public function simularParcelamento(float $valorTotal, array $prazos = [12, 24, 36, 48, 60], ?float $taxaMensal = null): array
    {
        $i = $taxaMensal ?? $this->taxaMensalPadrao;
        $simulacoes = [];

        foreach ($prazos as $n) {
            $n = (int) $n;

            if ($n <= 0) {
                continue;
            }

            if ($i > 0) {
                $fator = pow(1 + $i, $n);
                $valorParcela = $valorTotal * ($i * $fator) / ($fator - 1);
            } else {
                $valorParcela = $valorTotal / $n;
            }

            $totalComJuros = $valorParcela * $n;
            $totalJuros = $totalComJuros - $valorTotal;

            $simulacoes[] = [
                'parcelas' => $n,
                'taxa_mensal' => round($i * 100, 2),
                'valor_parcela' => round($valorParcela, 2),
                'total_com_juros' => round($totalComJuros, 2),
                'total_juros' => round($totalJuros, 2),
            ];
        }

        return $simulacoes;
    }

    public function processarPagamento(Usuario $usuario, iterable $itens, string $metodo = 'a_vista', int $parcelas = 1): array
    {
        $total = 0.0;

        foreach ($itens as $item) {
            if (! $item->carro || ! $item->carro->isDisponivel()) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'O veículo '.($item->carro ? $item->carro->modelo : '').' não está mais disponível.',
                ];
            }

            if ($item->carro->quantidade_disponivel < $item->quantidade) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Quantidade solicitada indisponível para o veículo '.$item->carro->modelo.'.',
                ];
            }

            $total += $item->calcularSubtotal();
        }

        foreach ($itens as $item) {
            $item->carro->diminuirEstoque($item->quantidade);
        }

        $usuario->carrinho()->delete();

        return [
            'sucesso' => true,
            'mensagem' => 'Pagamento e compra finalizados com sucesso!',
            'metodo' => $metodo,
            'parcelas' => $parcelas,
            'total' => $total,
        ];
    }
}
