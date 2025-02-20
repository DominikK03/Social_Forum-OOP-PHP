<?php

namespace app\PDO;
use app\PDO\Query\Query;
use app\PDO\Query\QueryBuilder;

interface MysqlClientInterface
{
    public function getResults(): array;
    public function persist(Query $query) : self;
    public function createQueryBuilder(): QueryBuilder;
    public function getOneOrNullResult(): ?array;
}
