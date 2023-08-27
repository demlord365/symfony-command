<?php

namespace App\Database;

use Psr\Log\LoggerInterface;

abstract class BaseClient implements DatabaseClientInterface
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->connect();
    }

    abstract protected function connect(): void;

    public function importData(array $data): void
    {
        array_shift($data); // Remove the first line (header)

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("INSERT INTO imported_data (uid, ctime, event_name) VALUES (:uid, :ctime, :event_name)");
            foreach ($data as $line) {

                $columns = explode(',', $line);

                $col1 = $columns[0];
                $col2 = $columns[1];
                $col3 = $columns[2];

                $stmt->bindParam(':uid', $col1);
                $stmt->bindParam(':ctime', $col2);
                $stmt->bindParam(':event_name', $col3);

                $stmt->execute();
            }
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            dd($e->getMessage());
        }
    }
}