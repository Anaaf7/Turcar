<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'e_mail' => ['required', 'email'],
            'senha' => ['required', 'string'],
        ]);

        $usuario = Usuario::where('e_mail', $request->input('e_mail'))->first();

        if (! $usuario || ! password_verify($request->input('senha'), $usuario->senha)) {
            return back()->withErrors([
                'e_mail' => 'As credenciais informadas não coincidem com nossos registros.',
            ])->withInput($request->except('senha'));
        }

        Auth::login($usuario);

        $request->session()->regenerate();
        $request->session()->put('usuario_id', $usuario->id);
        $request->session()->put('usuario_nome', $usuario->nome);

        return redirect()->intended(route('carros.index'))->with('sucesso', 'Login efetuado com sucesso!');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
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

        $usuario = Usuario::create([
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

        Auth::login($usuario);

        $request->session()->regenerate();
        $request->session()->put('usuario_id', $usuario->id);
        $request->session()->put('usuario_nome', $usuario->nome);

        return redirect()->route('carros.index')->with('sucesso', 'Cadastro realizado com sucesso!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sucesso', 'Sessão encerrada com sucesso!');
    }
}
