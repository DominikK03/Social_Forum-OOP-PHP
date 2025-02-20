<?php

namespace app\PDO;

use app\PDO\Query\Query;
use app\PDO\Query\QueryBuilder;
use PDO;
use PDOStatement;

class PDOMysqlClient implements MysqlClientInterface
{
    private PDO $pdo;
    private PDOStatement $statement;
    public function __construct()
    {
        $this->pdo = PDOConnectionFactory::createConnection(
            new PDOConnectionConfig(
                'mysql',
                'db',
                'rettiwt',
                'root',
                'root'
            )
        );
    }
    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }
    public function persist(Query $query): self
    {
        $this->statement = $this->pdo->prepare($query->showStatement());
        $this->statement->execute();
        return $this;
    }
    public function getResults(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOneOrNullResult(): ?array
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
