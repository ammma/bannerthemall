<?php

namespace App\Persistence;

use App\Persistence\Driver\PersistenceDriverInterface;

class Writer implements WriterInterface
{
    public function __construct(protected PersistenceDriverInterface $persistenceDriver)
    {
    }

    public function insertOnDuplicateUpdate(string $table, array $insertData, array $updateData)
    {
        $this->persistenceDriver->insertOnDuplicateUpdate($table, $insertData, $updateData);
    }
}
