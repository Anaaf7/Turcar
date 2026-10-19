<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_visualizar_tela_de_login(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Entrar no Sistema');
    }

    public function test_usuario_maior_de_18_anos_pode_se_cadastrar_com_sucesso(): void
    {
        $response = $this->post('/cadastro', [
            'nome' => 'Mariana Oliveira',
            'cpf' => '999.888.777-66',
            'data_nascimento' => '2000-01-01',
            'e_mail' => 'mariana@exemplo.com',
            'telefone' => '(11) 91234-5678',
            'endereco' => 'Rua das Flores',
            'numero' => '123',
            'cidade' => 'Campinas',
            'estado' => 'SP',
            'senha' => 'senhaSegura123',
            'senha_confirmation' => 'senhaSegura123',
        ]);

        $response->assertRedirect('/carros');
        $this->assertAuthenticated();

        $usuario = Usuario::where('e_mail', 'mariana@exemplo.com')->first();
        $this->assertNotNull($usuario);
        $this->assertTrue(password_verify('senhaSegura123', $usuario->senha));
    }

    public function test_usuario_menor_de_18_anos_e_bloqueado_no_cadastro(): void
    {
        $response = $this->post('/cadastro', [
            'nome' => 'Jovem Menor',
            'cpf' => '111.222.333-44',
            'data_nascimento' => now()->subYears(16)->format('Y-m-d'),
            'e_mail' => 'menor@exemplo.com',
            'telefone' => '(11) 90000-0000',
            'endereco' => 'Rua Sem Saida',
            'numero' => '1',
            'cidade' => 'Sao Paulo',
            'estado' => 'SP',
            'senha' => 'senhaSegura123',
            'senha_confirmation' => 'senhaSegura123',
        ]);

        $response->assertSessionHasErrors(['data_nascimento']);
        $this->assertGuest();
        $this->assertDatabaseMissing('usuarios', ['e_mail' => 'menor@exemplo.com']);
    }

    public function test_usuario_com_senha_invalida_nao_consegue_fazer_login(): void
    {
        $usuario = Usuario::create([
            'nome' => 'Usuario Teste',
            'cpf' => '222.333.444-55',
            'data_nascimento' => '1990-01-01',
            'e_mail' => 'teste@exemplo.com',
            'telefone' => '(11) 98888-7777',
            'endereco' => 'Rua Central',
            'numero' => '50',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'senha' => password_hash('senhaCorreta123', PASSWORD_DEFAULT),
        ]);

        $response = $this->post('/login', [
            'e_mail' => 'teste@exemplo.com',
            'senha' => 'senhaErrada',
        ]);

        $response->assertSessionHasErrors(['e_mail']);
        $this->assertGuest();
    }

    public function test_usuario_com_credenciais_validas_consegue_fazer_login(): void
    {
        Usuario::create([
            'nome' => 'Usuario Teste',
            'cpf' => '222.333.444-55',
            'data_nascimento' => '1990-01-01',
            'e_mail' => 'teste@exemplo.com',
            'telefone' => '(11) 98888-7777',
            'endereco' => 'Rua Central',
            'numero' => '50',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'senha' => password_hash('senhaCorreta123', PASSWORD_DEFAULT),
        ]);

        $response = $this->post('/login', [
            'e_mail' => 'teste@exemplo.com',
            'senha' => 'senhaCorreta123',
        ]);

        $response->assertRedirect('/carros');
        $this->assertAuthenticated();
    }

    public function test_usuario_pode_fazer_logout(): void
    {
        $usuario = Usuario::create([
            'nome' => 'Usuario Logout',
            'cpf' => '333.444.555-66',
            'data_nascimento' => '1992-02-02',
            'e_mail' => 'logout@exemplo.com',
            'telefone' => '(11) 97777-6666',
            'endereco' => 'Rua da Paz',
            'numero' => '200',
            'cidade' => 'Campinas',
            'estado' => 'SP',
            'senha' => password_hash('senha12345', PASSWORD_DEFAULT),
        ]);

        $response = $this->actingAs($usuario)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
