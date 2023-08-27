<?php

namespace App\Database;

use Psr\Log\LoggerInterface;

final class DatabaseClientFactory
{
    public static function createClient(string $type): DatabaseClientInterface
    {
        switch ($type) {
            case 'postgres':
                return new PostgresClient();
            case 'redis':
                return new RedisClient();
            case 'mysql':
                return new MysqlClient();
            default:
                throw new \InvalidArgumentException('Invalid database type');
        }
    }

}