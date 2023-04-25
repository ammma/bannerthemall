<?php
namespace App\Persistence\Driver;

interface PersistenceDriverInterface
{
    public function insertOnDuplicateUpdate(string $table, array $insertData, array $updateData): string;
}
