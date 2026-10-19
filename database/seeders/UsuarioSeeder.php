<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Carlos Eduardo Silva',
            'cpf' => '123.456.789-00',
            'data_nascimento' => '1995-05-15',
            'e_mail' => 'carlos@turcar.com',
            'telefone' => '(11) 98765-4321',
            'endereco' => 'Avenida Paulista',
            'numero' => '1000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'senha' => password_hash('12345678', PASSWORD_DEFAULT),
        ]);
    }
}
