<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Models\Pagamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarroController extends Controller
{
    public function index(Request $request): View
    {
        $query = Carro::query();

        if ($request->filled('marca')) {
            $query->where('marca', 'like', '%' . $request->input('marca') . '%');
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', '%' . $request->input('modelo') . '%');
        }

        if ($request->filled('ano')) {
            $query->where('ano', (int) $request->input('ano'));
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', (float) $request->input('preco_min'));
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', (float) $request->input('preco_max'));
        }

        if ($request->filled('combustivel')) {
            $query->where('combustivel', $request->input('combustivel'));
        }

        if ($request->filled('cambio')) {
            $query->where('cambio', $request->input('cambio'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $carros = $query->orderBy('id', 'desc')->get();

        $marcas = Carro::select('marca')->distinct()->pluck('marca');
        $combustiveis = Carro::select('combustivel')->distinct()->pluck('combustivel');
        $cambios = Carro::select('cambio')->distinct()->pluck('cambio');

        return view('carros.index', compact('carros', 'marcas', 'combustiveis', 'cambios'));
    }

    public function create(): View
    {
        return view('carros.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'versao' => ['required', 'string', 'max:255'],
            'ano' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'preco' => ['required', 'numeric', 'min:0'],
            'quilometragem' => ['required', 'integer', 'min:0'],
            'cor' => ['required', 'string', 'max:50'],
            'combustivel' => ['required', 'string', 'max:50'],
            'cambio' => ['required', 'string', 'max:50'],
            'numero_portas' => ['required', 'integer', 'min:1', 'max:8'],
            'descricao' => ['required', 'string'],
            'imagem' => ['required', 'string'],
            'quantidade_disponivel' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:disponivel,vendido,reservado'],
        ]);

        Carro::create($dados);

        return redirect()->route('carros.index')->with('sucesso', 'Veículo cadastrado com sucesso!');
    }

    public function show(Carro $carro): View
    {
        $pagamento = new Pagamento();
        $simulacoes = $pagamento->simularParcelamento((float) $carro->preco);

        return view('carros.show', compact('carro', 'simulacoes'));
    }

    public function edit(Carro $carro): View
    {
        return view('carros.edit', compact('carro'));
    }

    public function update(Request $request, Carro $carro): RedirectResponse
    {
        $dados = $request->validate([
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'versao' => ['required', 'string', 'max:255'],
            'ano' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'preco' => ['required', 'numeric', 'min:0'],
            'quilometragem' => ['required', 'integer', 'min:0'],
            'cor' => ['required', 'string', 'max:50'],
            'combustivel' => ['required', 'string', 'max:50'],
            'cambio' => ['required', 'string', 'max:50'],
            'numero_portas' => ['required', 'integer', 'min:1', 'max:8'],
            'descricao' => ['required', 'string'],
            'imagem' => ['required', 'string'],
            'quantidade_disponivel' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:disponivel,vendido,reservado'],
        ]);

        $carro->update($dados);

        return redirect()->route('carros.show', $carro)->with('sucesso', 'Veículo atualizado com sucesso!');
    }

    public function destroy(Carro $carro): RedirectResponse
    {
        $carro->delete();

        return redirect()->route('carros.index')->with('sucesso', 'Veículo excluído com sucesso!');
    }
}
