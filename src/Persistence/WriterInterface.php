<?php

namespace App\Persistence;

interface WriterInterface
{
    public function insertOnDuplicateUpdate(string $table, array $insertData, array $updateData);
}
