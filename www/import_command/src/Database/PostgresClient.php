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

//    public function importData(array $data): void
//    {
//        array_shift($data); // Remove the first line (header)
//
//        $this->pdo->beginTransaction();
//
//        try {
//            $stmt = $this->pdo->prepare("INSERT INTO imported_data (uid, ctime, event_name) VALUES (:uid, :ctime, :event_name)");
//            foreach ($data as $line) {
//                //Clean the line from double quotes
//                $pieces = str_getcsv($line, ',');
//                //$cleanedLine = preg_replace('/"([^"]*)","([^"]*)","([^"]*)"/', '$1,$2,$3', $pieces[0]);
//                $cleanedLine = str_replace('"', '', $pieces[0]);
//                $columns = explode(',', $cleanedLine);
//
//                $col1 = $columns[0];
//                $col2 = $columns[1];
//                $col3 = $columns[2];
//
//                $stmt->bindParam(':uid', $col1);
//                $stmt->bindParam(':ctime', $col2);
//                $stmt->bindParam(':event_name', $col3);
//
//                $stmt->execute();
//            }
//            $this->pdo->commit();
//        } catch (\PDOException $e) {
//            $this->pdo->rollBack();
//            dd($e->getMessage());
//        }
//
//    }
}