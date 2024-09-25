<?php

namespace app;

use PDO;
use PDOException;
use PDOStatement;

class DB
{
    private PDO $pdo;
    private PDOStatement $statement;

    public function __construct(array $config)
    {
        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
    public function query(string $query): void
    {
        $this->statement = $this->pdo->prepare($query);
    }

    public function bind($param, $value, $type = null): void
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }
        $this->statement->bindValue($param, $value, $type);
    }

    public function execute(): bool
    {
        return $this->statement->execute();
    }

    public function single()
    {
        $this->execute();
        return $this->statement->fetch();
    }

    public function resultSet(): false|array
    {
        $this->execute();
        return $this->statement->fetchAll();
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $this->query($query);

        foreach ($data as $param => $value) {
            $this->bind(':' . $param, $value);
        }

        return $this->execute();
    }

}