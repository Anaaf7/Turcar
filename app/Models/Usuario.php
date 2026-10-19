<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'e_mail',
        'telefone',
        'endereco',
        'numero',
        'cidade',
        'estado',
        'senha',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'senha';
    }

    public function getAuthPassword(): string
    {
        return $this->senha;
    }

    public function carrinho(): HasMany
    {
        return $this->hasMany(Carrinho::class, 'usuario_id');
    }

    public function isMaiorDeIdade(): bool
    {
        if (! $this->data_nascimento) {
            return false;
        }

        return Carbon::parse($this->data_nascimento)->age >= 18;
    }
}
