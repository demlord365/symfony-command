<?php

namespace App\Database;

interface DatabaseClientInterface
{
    //protected function connect(): void;

    public function importData(array $data): void;
}