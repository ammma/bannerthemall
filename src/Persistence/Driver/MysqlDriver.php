<?php

namespace App\Persistence\Driver;

use PDO;

class MysqlDriver implements PersistenceDriverInterface
{
    protected static $conn;

    public function __construct(
        string $host,
        string $username,
        string $password,
        string $database
    ) {
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";

        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        if (static::$conn instanceof PDO) {
            return;
        }

        static::$conn = new PDO($dsn, $username, $password, $options);
    }

    public function insertOnDuplicateUpdate(string $table, array $insertData, array $updateData): string
    {
        $keys = array_keys($insertData);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s",
            $table,
            implode(',', $keys),
            implode(',', array_fill(0, count($keys), '?')),
            implode(
                ',',
                array_map(function ($key, $value) {
                    return $key . "=" . $value;
                }, array_keys($updateData), $updateData)
            )
        );

        $stmt = static::$conn->prepare($sql);

        $stmt->execute(array_values($insertData));

        return static::$conn->lastInsertId();
    }

    public function __destruct()
    {
        static::$conn = null;
    }
}
