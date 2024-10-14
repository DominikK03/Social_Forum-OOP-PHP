<?php

namespace app;

interface MysqlClientInterface
{
    public function getResults(Query $query): array;
    public function createQueryBuilder(): QueryBuilder;
    public function pushWithoutResults(Query $query);
    public function getOneOrNullResult(Query $query): ?array;


}
