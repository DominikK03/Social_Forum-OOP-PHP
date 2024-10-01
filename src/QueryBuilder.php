<?php

namespace app;

use AllowDynamicProperties;

#[AllowDynamicProperties] class QueryBuilder
{
    public function __construct()
    {
        $this->query = new Query();
    }

    public function select(string $columnName = '*'): void
    {
        $this->query->setSelect(sprintf("SELECT %s FROM", $columnName));
    }

    public function from(string $tableName, string $alias=''): void
    {
        $this->query->setFrom($alias ? sprintf("%s AS %s", $tableName, $alias) : $tableName);
    }


    public function delete(string $tableName): void
    {
        $this->query->setDelete(sprintf('DELETE FROM %s WHERE ', $tableName));

    }

    public function join(string $joinedTable, string $alias, string $conditional, string $joinType = 'INNER'): void
    {
        $this->query->addJoin(sprintf("%s JOIN %s AS %s ON %s", $joinType, $joinedTable, $alias, $conditional));

    }

    public function where(string $field, string $operator, mixed $value): void
    {
        $this->query->addWhere(sprintf('%s %s "%s"', $field, $operator, $value));

    }

    public function orderBy(string $field, string $direction = 'ASC'): void
    {
        $this->query->addOrderBy(sprintf("%s %s", $field, strtoupper($direction)));

    }

    public function groupBy(string $field): void
    {
        $this->query->addGroupBy($field);

    }

    public function limit(int $limit): void
    {
        $this->query->setLimit($limit);

    }

    public function addParams(array $params): void
    {
        foreach ($params as $key => $value) {
            $this->query->setParams([$key => $value]);
        }
    }
    public  function insert(string $tableName, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function($data) {
            return '"' . $data . '"';
        }, array_values($data)));
        $this->query->setInsert(sprintf('INSERT INTO %s (%s) VALUES (%s)', $tableName, $columns, $values));
    }
    public function update(string $tableName, array $data)
    {
        $setPart = implode(", ", array_map(fn($key, $value) => "$key = $value", array_keys($data), array_values($data)));
        $this->query->setUpdate(sprintf("UPDATE %s SET %s", $tableName, $setPart));
    }

    public function getSelectQuery(): Query
    {
        $this->query->formatSelectQuery();
        return $this->query;
    }
    public function getDeleteQuery() : Query
    {
        $this->query->formatDeleteQuery();
        return $this->query;
    }
    public function getInsertQuery():Query
    {
        $this->query->formatInsertQuery();
        return $this->query;
    }

    public function getUpdateQuery(): Query
    {
        $this->query->formatUpdateQuery();
        return $this->query;
    }






}
