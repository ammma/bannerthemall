<?php

namespace App\Persistence;

use App\Config\Config;
use App\Persistence\Driver\MysqlDriver;
use App\Persistence\Driver\PersistenceDriverInterface;

class PersistenceFactory
{
    public function createWriter(): WriterInterface
    {
        return new Writer($this->createMysqlDriver());
    }

    public function createMysqlDriver(): PersistenceDriverInterface
    {
        return new MysqlDriver(
            Config::get('db_host'),
            Config::get('db_user'),
            Config::get('db_pwd'),
            Config::get('db_name'),
        );
    }
}
