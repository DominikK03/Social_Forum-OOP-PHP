<?php

namespace app;

use PDO;
use PDOException;
use PDOStatement;

class MysqlClient implements MysqlClientInterface
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
    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }

    public function getResults(Query $query): array
    {
        $statement = $this->pdo->prepare($query->getStatement());

        foreach ($query->getParams() as $param => $value) {
            $statement->bindValue(":$param", $value);
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneOrNullResult(Query $query): array
    {


    }


}