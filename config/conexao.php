<?php

use App\Models\Conexao;

return [
    'pdo' => function (): PDO {
        return Conexao::getConexao();
    },
];
