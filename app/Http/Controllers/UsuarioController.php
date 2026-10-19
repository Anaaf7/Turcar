<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = Usuario::orderBy('id', 'desc')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', 'unique:usuarios,cpf'],
            'data_nascimento' => ['required', 'date'],
            'e_mail' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,e_mail'],
            'telefone' => ['required', 'string', 'max:20'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'max:50'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $nascimento = Carbon::parse($dados['data_nascimento']);
        if ($nascimento->age < 18) {
            return back()->withErrors([
                'data_nascimento' => 'O cadastro é permitido apenas para maiores de 18 anos.',
            ])->withInput($request->except('senha', 'senha_confirmation'));
        }

        Usuario::create([
            'nome' => $dados['nome'],
            'cpf' => $dados['cpf'],
            'data_nascimento' => $dados['data_nascimento'],
            'e_mail' => $dados['e_mail'],
            'telefone' => $dados['telefone'],
            'endereco' => $dados['endereco'],
            'numero' => $dados['numero'],
            'cidade' => $dados['cidade'],
            'estado' => $dados['estado'],
            'senha' => password_hash($dados['senha'], PASSWORD_DEFAULT),
        ]);

        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', Rule::unique('usuarios', 'cpf')->ignore($usuario->id)],
            'data_nascimento' => ['required', 'date'],
            'e_mail' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'e_mail')->ignore($usuario->id)],
            'telefone' => ['required', 'string', 'max:20'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'max:50'],
            'senha' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $nascimento = Carbon::parse($dados['data_nascimento']);
        if ($nascimento->age < 18) {
            return back()->withErrors([
                'data_nascimento' => 'O cadastro é permitido apenas para maiores de 18 anos.',
            ])->withInput($request->except('senha', 'senha_confirmation'));
        }

        $usuario->fill([
            'nome' => $dados['nome'],
            'cpf' => $dados['cpf'],
            'data_nascimento' => $dados['data_nascimento'],
            'e_mail' => $dados['e_mail'],
            'telefone' => $dados['telefone'],
            'endereco' => $dados['endereco'],
            'numero' => $dados['numero'],
            'cidade' => $dados['cidade'],
            'estado' => $dados['estado'],
        ]);

        if (! empty($dados['senha'])) {
            $usuario->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
        }

        $usuario->save();

        return redirect()->route('usuarios.show', $usuario)->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $ehUsuarioAtual = Auth::id() === $usuario->id;

        $usuario->delete();

        if ($ehUsuarioAtual) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')->with('sucesso', 'Sua conta foi excluída com sucesso.');
        }

        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário removido com sucesso!');
    }
}
