<?php

namespace App\Database;

use App\Database\BaseClient;
use Symfony\Component\Cache\Adapter\PdoAdapter;
use Psr\Log\LoggerInterface;

class MysqlClient extends BaseClient
{

    protected function connect(): void
    {
        try {
            $this->pdo = new \PDO($_ENV['MYSQL_DSN'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        } catch (\PDOException $e) {
            dd($e->getMessage());
        }
    }

}


