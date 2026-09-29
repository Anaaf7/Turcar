<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    private function criarUsuario(string $email = 'admin@turcar.com', string $cpf = '111.222.333-44'): Usuario
    {
        return Usuario::create([
            'nome' => 'Usuario Teste',
            'cpf' => $cpf,
            'data_nascimento' => '1990-01-01',
            'e_mail' => $email,
            'telefone' => '(11) 98765-4321',
            'endereco' => 'Avenida Principal',
            'numero' => '100',
            'cidade' => 'Sao Paulo',
            'estado' => 'SP',
            'senha' => password_hash('12345678', PASSWORD_DEFAULT),
        ]);
    }

    public function test_usuario_autenticado_pode_listar_usuarios(): void
    {
        $usuario = $this->criarUsuario();

        $response = $this->actingAs($usuario)->get('/usuarios');

        $response->assertStatus(200);
        $response->assertSee('Usuario Teste');
    }

    public function test_usuario_autenticado_pode_visualizar_perfil(): void
    {
        $usuario = $this->criarUsuario();

        $response = $this->actingAs($usuario)->get('/usuarios/' . $usuario->id);

        $response->assertStatus(200);
        $response->assertSee($usuario->nome);
        $response->assertSee($usuario->cpf);
    }

    public function test_usuario_autenticado_pode_atualizar_dados(): void
    {
        $usuario = $this->criarUsuario();

        $response = $this->actingAs($usuario)->put('/usuarios/' . $usuario->id, [
            'nome' => 'Nome Atualizado',
            'cpf' => $usuario->cpf,
            'data_nascimento' => '1990-01-01',
            'e_mail' => 'novoemail@turcar.com',
            'telefone' => '(11) 99999-0000',
            'endereco' => 'Rua Nova',
            'numero' => '200',
            'cidade' => 'Campinas',
            'estado' => 'SP',
        ]);

        $response->assertRedirect('/usuarios/' . $usuario->id);
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'nome' => 'Nome Atualizado',
            'e_mail' => 'novoemail@turcar.com',
        ]);
    }
}
