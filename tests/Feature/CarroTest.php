<?php

namespace Tests\Feature;

use App\Models\Carro;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarroTest extends TestCase
{
    use RefreshDatabase;

    private function criarUsuario(): Usuario
    {
        return Usuario::create([
            'nome' => 'Admin Teste',
            'cpf' => '555.666.777-88',
            'data_nascimento' => '1990-01-01',
            'e_mail' => 'admin@turcar.com',
            'telefone' => '(11) 99999-8888',
            'endereco' => 'Rua das Oliveiras',
            'numero' => '10',
            'cidade' => 'Sao Paulo',
            'estado' => 'SP',
            'senha' => password_hash('12345678', PASSWORD_DEFAULT),
        ]);
    }

    public function test_qualquer_visitante_pode_listar_carros(): void
    {
        Carro::create([
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'versao' => 'XEi',
            'ano' => 2022,
            'preco' => 130000.00,
            'quilometragem' => 30000,
            'cor' => 'Prata',
            'combustivel' => 'Flex',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Veiculo impecavel',
            'imagem' => 'https://exemplo.com/corolla.jpg',
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        $response = $this->get('/carros');

        $response->assertStatus(200);
        $response->assertSee('Corolla');
    }

    public function test_filtros_de_busca_de_carros_funcionam_corretamente(): void
    {
        Carro::create([
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'versao' => 'Altis',
            'ano' => 2023,
            'preco' => 150000.00,
            'quilometragem' => 10000,
            'cor' => 'Branco',
            'combustivel' => 'Flex',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Corolla novo',
            'imagem' => 'https://exemplo.com/corolla.jpg',
            'quantidade_disponivel' => 1,
            'status' => 'disponivel',
        ]);

        Carro::create([
            'marca' => 'Honda',
            'modelo' => 'Civic',
            'versao' => 'Touring',
            'ano' => 2021,
            'preco' => 140000.00,
            'quilometragem' => 40000,
            'cor' => 'Preto',
            'combustivel' => 'Gasolina',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Civic turbo',
            'imagem' => 'https://exemplo.com/civic.jpg',
            'quantidade_disponivel' => 1,
            'status' => 'disponivel',
        ]);

        $response = $this->get('/carros?marca=Honda');
        $response->assertSee('Civic');
        $response->assertDontSee('Corolla');

        $responsePreco = $this->get('/carros?preco_min=145000');
        $responsePreco->assertSee('Corolla');
        $responsePreco->assertDontSee('Civic');
    }

    public function test_detalhes_do_carro_exibem_simulacao_de_parcelas(): void
    {
        $carro = Carro::create([
            'marca' => 'Volkswagen',
            'modelo' => 'Golf',
            'versao' => 'GTI',
            'ano' => 2021,
            'preco' => 100000.00,
            'quilometragem' => 20000,
            'cor' => 'Vermelho',
            'combustivel' => 'Gasolina',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Golf GTI esportivo',
            'imagem' => 'https://exemplo.com/golf.jpg',
            'quantidade_disponivel' => 1,
            'status' => 'disponivel',
        ]);

        $response = $this->get('/carros/' . $carro->id);

        $response->assertStatus(200);
        $response->assertSee('Golf');
        $response->assertSee('Simulacao de Parcelamento');
        $response->assertSee('12x');
        $response->assertSee('60x');
    }

    public function test_usuario_autenticado_pode_cadastrar_novo_carro(): void
    {
        $usuario = $this->criarUsuario();

        $response = $this->actingAs($usuario)->post('/carros', [
            'marca' => 'Ford',
            'modelo' => 'Ranger',
            'versao' => 'Storm 3.2 4x4',
            'ano' => 2022,
            'preco' => 190000.00,
            'quilometragem' => 45000,
            'cor' => 'Preto',
            'combustivel' => 'Diesel',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Picape off-road excelente',
            'imagem' => 'https://exemplo.com/ranger.jpg',
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        $response->assertRedirect('/carros');
        $this->assertDatabaseHas('carros', [
            'modelo' => 'Ranger',
            'marca' => 'Ford',
        ]);
    }

    public function test_visitante_nao_pode_cadastrar_carro(): void
    {
        $response = $this->post('/carros', [
            'marca' => 'Ford',
            'modelo' => 'Ranger',
            'versao' => 'Storm',
            'ano' => 2022,
            'preco' => 190000.00,
            'quilometragem' => 45000,
            'cor' => 'Preto',
            'combustivel' => 'Diesel',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Picape off-road',
            'imagem' => 'https://exemplo.com/ranger.jpg',
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        $response->assertRedirect('/login');
    }
}
