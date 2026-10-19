<?php

namespace Tests\Feature;

use App\Models\Carrinho;
use App\Models\Carro;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarrinhoTest extends TestCase
{
    use RefreshDatabase;

    private function criarUsuario(): Usuario
    {
        return Usuario::create([
            'nome' => 'Comprador Teste',
            'cpf' => '777.888.999-00',
            'data_nascimento' => '1996-03-20',
            'e_mail' => 'comprador@turcar.com',
            'telefone' => '(11) 98765-1111',
            'endereco' => 'Avenida Brasil',
            'numero' => '500',
            'cidade' => 'Sao Paulo',
            'estado' => 'SP',
            'senha' => password_hash('12345678', PASSWORD_DEFAULT),
        ]);
    }

    private function criarCarro(string $modelo = 'Corolla', float $preco = 100000.00, int $estoque = 3): Carro
    {
        return Carro::create([
            'marca' => 'Toyota',
            'modelo' => $modelo,
            'versao' => 'XEi 2.0',
            'ano' => 2023,
            'preco' => $preco,
            'quilometragem' => 15000,
            'cor' => 'Branco',
            'combustivel' => 'Flex',
            'cambio' => 'Automático',
            'numero_portas' => 4,
            'descricao' => 'Veiculo bem conservado',
            'imagem' => 'https://exemplo.com/carro.jpg',
            'quantidade_disponivel' => $estoque,
            'status' => 'disponivel',
        ]);
    }

    public function test_visitante_e_redirecionado_ao_tentar_acessar_carrinho(): void
    {
        $response = $this->get('/carrinho');

        $response->assertRedirect('/login');
    }

    public function test_usuario_autenticado_pode_adicionar_carro_ao_carrinho(): void
    {
        $usuario = $this->criarUsuario();
        $carro = $this->criarCarro();

        $response = $this->actingAs($usuario)->post('/carrinho/'.$carro->id, [
            'quantidade' => 1,
        ]);

        $response->assertRedirect('/carrinho');
        $this->assertDatabaseHas('carrinho', [
            'usuario_id' => $usuario->id,
            'carro_id' => $carro->id,
            'quantidade' => 1,
        ]);
    }

    public function test_carrinho_calcula_subtotal_e_total_corretamente(): void
    {
        $usuario = $this->criarUsuario();
        $carro1 = $this->criarCarro('Corolla', 100000.00, 5);
        $carro2 = $this->criarCarro('Civic', 150000.00, 5);

        Carrinho::create([
            'usuario_id' => $usuario->id,
            'carro_id' => $carro1->id,
            'quantidade' => 2,
        ]);

        Carrinho::create([
            'usuario_id' => $usuario->id,
            'carro_id' => $carro2->id,
            'quantidade' => 1,
        ]);

        $response = $this->actingAs($usuario)->get('/carrinho');

        $response->assertStatus(200);
        $response->assertSee('200.000,00');
        $response->assertSee('150.000,00');
        $response->assertSee('350.000,00');
        $response->assertSee('Simulacao de Financiamento');
    }

    public function test_usuario_pode_atualizar_quantidade_no_carrinho(): void
    {
        $usuario = $this->criarUsuario();
        $carro = $this->criarCarro('Onix', 80000.00, 5);

        $item = Carrinho::create([
            'usuario_id' => $usuario->id,
            'carro_id' => $carro->id,
            'quantidade' => 1,
        ]);

        $response = $this->actingAs($usuario)->put('/carrinho/'.$item->id, [
            'quantidade' => 3,
        ]);

        $response->assertRedirect('/carrinho');
        $this->assertDatabaseHas('carrinho', [
            'id' => $item->id,
            'quantidade' => 3,
        ]);
    }

    public function test_usuario_pode_remover_item_do_carrinho(): void
    {
        $usuario = $this->criarUsuario();
        $carro = $this->criarCarro();

        $item = Carrinho::create([
            'usuario_id' => $usuario->id,
            'carro_id' => $carro->id,
            'quantidade' => 1,
        ]);

        $response = $this->actingAs($usuario)->delete('/carrinho/'.$item->id);

        $response->assertRedirect('/carrinho');
        $this->assertDatabaseMissing('carrinho', [
            'id' => $item->id,
        ]);
    }

    public function test_usuario_pode_limpar_todo_o_carrinho(): void
    {
        $usuario = $this->criarUsuario();
        $carro1 = $this->criarCarro('Corolla');
        $carro2 = $this->criarCarro('Civic');

        Carrinho::create(['usuario_id' => $usuario->id, 'carro_id' => $carro1->id, 'quantidade' => 1]);
        Carrinho::create(['usuario_id' => $usuario->id, 'carro_id' => $carro2->id, 'quantidade' => 1]);

        $response = $this->actingAs($usuario)->post('/carrinho/limpar');

        $response->assertRedirect('/carrinho');
        $this->assertDatabaseCount('carrinho', 0);
    }

    public function test_usuario_pode_finalizar_compra_atualizando_estoque_e_esvaziando_carrinho(): void
    {
        $usuario = $this->criarUsuario();
        $carro = $this->criarCarro('HB20', 90000.00, 2);

        Carrinho::create([
            'usuario_id' => $usuario->id,
            'carro_id' => $carro->id,
            'quantidade' => 2,
        ]);

        $response = $this->actingAs($usuario)->post('/carrinho/finalizar', [
            'metodo' => 'financiamento',
            'parcelas' => 24,
        ]);

        $response->assertRedirect('/carros');
        $this->assertDatabaseCount('carrinho', 0);

        $carroAtualizado = Carro::find($carro->id);
        $this->assertEquals(0, $carroAtualizado->quantidade_disponivel);
        $this->assertEquals('vendido', $carroAtualizado->status);
    }
}
