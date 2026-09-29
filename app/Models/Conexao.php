<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class Conexao
{
    private static ?PDO $instance = null;

    public static function getConexao(): PDO
    {
        if (self::$instance === null) {
            self::$instance = DB::connection()->getPdo();
        }

        return self::$instance;
    }

    public static function select(string $sql, array $bindings = []): array
    {
        $stmt = self::getConexao()->prepare($sql);
        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function execute(string $sql, array $bindings = []): bool
    {
        $stmt = self::getConexao()->prepare($sql);

        return $stmt->execute($bindings);
    }
}
