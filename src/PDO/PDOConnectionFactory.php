<?php

namespace app\PDO;

use PDO;
use PDOException;

class PDOConnectionFactory
{
    public static function createConnection(ConnectionConfig $config): PDO
    {
        try {
            $pdo = new PDO($config->getDsn(), $config->getUser(), $config->getPassword());
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException("Connection error: " . $e->getMessage());
        }
    }
}
