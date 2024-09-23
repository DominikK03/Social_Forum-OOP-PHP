<?php

namespace app;

use PDO;

class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function insertUserData(array $values, string $table = 'users')
    {
        $this->pdo->exec("INSERT INTO " . $table . "(user_name, email, password)" .
            "VALUES" . '(' . $values['username'] . $values['email'] . $values['password'] . ');');

    }
}