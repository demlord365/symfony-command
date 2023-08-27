<?php

namespace App\Database;

use Predis\Client;
use Psr\Log\LoggerInterface;

class RedisClient implements DatabaseClientInterface
{
    private Client $redis;

    public function __construct()
    {
        $this->connect();
    }

    protected function connect(): void
    {
        try {
            $this->redis = new Client([
                'scheme' => $_ENV['REDIS_SCHEME'],
                'host' => $_ENV['REDIS_HOST'],
                'port' => $_ENV['REDIS_PORT']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function importData(array $data): void
    {
        array_shift($data); // Remove the first line (header)

        try {
            $this->redis->pipeline(function ($pipe) use ($data) {
                foreach ($data as $line) {

                    $columns = explode(',', $line);

                    $col1 = $columns[0];
                    $col2 = $columns[1];
                    $col3 = $columns[2];

                    // Create a hash key like 'data:uid'
                    $hashKey = 'data:' . $col1;

                    // Store data as a hash
                    $pipe->hset($hashKey, 'ctime', $col2);
                    $pipe->hset($hashKey, 'event_name', $col3);

                }
            });
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}