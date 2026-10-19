<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('carros.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/cadastro', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/cadastro', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/carros', [CarroController::class, 'index'])->name('carros.index');
Route::get('/carros/{carro}', [CarroController::class, 'show'])->whereNumber('carro')->name('carros.show');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/carros/novo', [CarroController::class, 'create'])->name('carros.create');
    Route::post('/carros', [CarroController::class, 'store'])->name('carros.store');
    Route::get('/carros/{carro}/editar', [CarroController::class, 'edit'])->whereNumber('carro')->name('carros.edit');
    Route::put('/carros/{carro}', [CarroController::class, 'update'])->whereNumber('carro')->name('carros.update');
    Route::delete('/carros/{carro}', [CarroController::class, 'destroy'])->whereNumber('carro')->name('carros.destroy');

    Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/carrinho/{carro}', [CarrinhoController::class, 'adicionar'])->whereNumber('carro')->name('carrinho.adicionar');
    Route::put('/carrinho/{carrinho}', [CarrinhoController::class, 'atualizar'])->whereNumber('carrinho')->name('carrinho.atualizar');
    Route::delete('/carrinho/{carrinho}', [CarrinhoController::class, 'remover'])->whereNumber('carrinho')->name('carrinho.remover');
    Route::post('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');
    Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');

    Route::resource('usuarios', UsuarioController::class);
});
