<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carros', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('versao');
            $table->integer('ano');
            $table->decimal('preco', 12, 2);
            $table->integer('quilometragem');
            $table->string('cor');
            $table->string('combustivel');
            $table->string('cambio');
            $table->integer('numero_portas');
            $table->text('descricao');
            $table->string('imagem');
            $table->integer('quantidade_disponivel')->default(1);
            $table->string('status')->default('disponivel');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carros');
    }
};
