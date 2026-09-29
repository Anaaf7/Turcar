<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carro extends Model
{
    use HasFactory;

    protected $table = 'carros';

    protected $fillable = [
        'marca',
        'modelo',
        'versao',
        'ano',
        'preco',
        'quilometragem',
        'cor',
        'combustivel',
        'cambio',
        'numero_portas',
        'descricao',
        'imagem',
        'quantidade_disponivel',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'ano' => 'integer',
            'preco' => 'decimal:2',
            'quilometragem' => 'integer',
            'numero_portas' => 'integer',
            'quantidade_disponivel' => 'integer',
        ];
    }

    public function carrinho(): HasMany
    {
        return $this->hasMany(Carrinho::class, 'carro_id');
    }

    public function isDisponivel(): bool
    {
        return $this->status === 'disponivel' && $this->quantidade_disponivel > 0;
    }

    public function diminuirEstoque(int $quantidade = 1): bool
    {
        if ($this->quantidade_disponivel < $quantidade) {
            return false;
        }

        $this->quantidade_disponivel -= $quantidade;

        if ($this->quantidade_disponivel <= 0) {
            $this->quantidade_disponivel = 0;
            $this->status = 'vendido';
        }

        return $this->save();
    }
}
