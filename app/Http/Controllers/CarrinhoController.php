<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Carro;
use App\Models\Pagamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CarrinhoController extends Controller
{
    public function index(Request $request): View
    {
        $usuario = Auth::user();
        $itens = Carrinho::with('carro')
            ->where('usuario_id', $usuario->id)
            ->get();

        $pagamento = new Pagamento();
        $total = $pagamento->calcularTotal($itens);

        $simulacoes = $total > 0 ? $pagamento->simularParcelamento($total) : [];

        return view('carrinho.index', compact('itens', 'total', 'simulacoes'));
    }

    public function adicionar(Request $request, Carro $carro): RedirectResponse
    {
        if (! $carro->isDisponivel()) {
            return back()->with('erro', 'Veículo indisponível para compra.');
        }

        $usuario = Auth::user();
        $quantidadeDesejada = (int) $request->input('quantidade', 1);

        if ($quantidadeDesejada <= 0) {
            $quantidadeDesejada = 1;
        }

        $item = Carrinho::where('usuario_id', $usuario->id)
            ->where('carro_id', $carro->id)
            ->first();

        $novaQuantidade = $item ? ($item->quantidade + $quantidadeDesejada) : $quantidadeDesejada;

        if ($novaQuantidade > $carro->quantidade_disponivel) {
            return back()->with('erro', 'Quantidade solicitada excede o estoque disponível (' . $carro->quantidade_disponivel . ').');
        }

        if ($item) {
            $item->quantidade = $novaQuantidade;
            $item->save();
        } else {
            Carrinho::create([
                'usuario_id' => $usuario->id,
                'carro_id' => $carro->id,
                'quantidade' => $quantidadeDesejada,
            ]);
        }

        return redirect()->route('carrinho.index')->with('sucesso', 'Veículo adicionado ao carrinho com sucesso!');
    }

    public function atualizar(Request $request, Carrinho $carrinho): RedirectResponse
    {
        $usuario = Auth::user();

        if ($carrinho->usuario_id !== $usuario->id) {
            return back()->with('erro', 'Ação não permitida.');
        }

        $request->validate([
            'quantidade' => ['required', 'integer', 'min:1'],
        ]);

        $novaQuantidade = (int) $request->input('quantidade');

        if ($carrinho->carro && $novaQuantidade > $carrinho->carro->quantidade_disponivel) {
            return back()->with('erro', 'Quantidade solicitada excede o estoque disponível (' . $carrinho->carro->quantidade_disponivel . ').');
        }

        $carrinho->quantidade = $novaQuantidade;
        $carrinho->save();

        return redirect()->route('carrinho.index')->with('sucesso', 'Quantidade atualizada!');
    }

    public function remover(Carrinho $carrinho): RedirectResponse
    {
        $usuario = Auth::user();

        if ($carrinho->usuario_id !== $usuario->id) {
            return back()->with('erro', 'Ação não permitida.');
        }

        $carrinho->delete();

        return redirect()->route('carrinho.index')->with('sucesso', 'Item removido do carrinho com sucesso!');
    }

    public function limpar(): RedirectResponse
    {
        $usuario = Auth::user();

        Carrinho::where('usuario_id', $usuario->id)->delete();

        return redirect()->route('carrinho.index')->with('sucesso', 'Carrinho esvaziado com sucesso!');
    }

    public function finalizar(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        $itens = Carrinho::with('carro')
            ->where('usuario_id', $usuario->id)
            ->get();

        if ($itens->isEmpty()) {
            return redirect()->route('carrinho.index')->with('erro', 'Seu carrinho está vazio.');
        }

        $metodo = $request->input('metodo', 'a_vista');
        $parcelas = (int) $request->input('parcelas', 1);

        $pagamento = new Pagamento();
        $resultado = $pagamento->processarPagamento($usuario, $itens, $metodo, $parcelas);

        if (! $resultado['sucesso']) {
            return redirect()->route('carrinho.index')->with('erro', $resultado['mensagem']);
        }

        return redirect()->route('carros.index')->with('sucesso', $resultado['mensagem']);
    }
}
