<?php

namespace app;

interface MysqlClientInterface
{
    public function getResults(Query $query): array;
    public function createQueryBuilder(): QueryBuilder;
}
