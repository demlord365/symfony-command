<?php

namespace App\Database;

class PostgresClient extends BaseClient
{

    protected function connect(): void
    {
        try {
            $this->pdo = new \PDO($_ENV['POSTGRES_DSN'], $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        } catch (\PDOException $e) {
            dd($e->getMessage());
        }
    }
    
}