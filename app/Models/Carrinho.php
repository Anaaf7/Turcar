<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrinho extends Model
{
    use HasFactory;

    protected $table = 'carrinho';

    protected $fillable = [
        'usuario_id',
        'carro_id',
        'quantidade',
    ];

    protected function casts(): array
    {
        return [
            'usuario_id' => 'integer',
            'carro_id' => 'integer',
            'quantidade' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function carro(): BelongsTo
    {
        return $this->belongsTo(Carro::class, 'carro_id');
    }

    public function calcularSubtotal(): float
    {
        if (! $this->carro) {
            return 0.0;
        }

        return (float) ($this->quantidade * (float) $this->carro->preco);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->calcularSubtotal();
    }
}
