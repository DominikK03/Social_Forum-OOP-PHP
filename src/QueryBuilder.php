<?php

namespace app;

use AllowDynamicProperties;

#[AllowDynamicProperties] class QueryBuilder
{
    public function __construct()
    {
        $this->query = new Query();
    }

    public function select(string $columnName = '*'): self
    {
        $this->query->setSelect(sprintf("SELECT %s FROM", $columnName));
        return $this;
    }

    public function from(string $tableName, string $alias = ''): self
    {
        $this->query->setFrom($alias ? sprintf("%s AS %s", $tableName, $alias) : $tableName);
        return $this;
    }


    public function delete(string $tableName): self
    {
        $this->query->setDelete(sprintf('DELETE FROM %s WHERE ', $tableName));
        return $this;
    }

    public function join(string $joinedTable, string $conditional, string $joinType = 'INNER', string $alias = null): self
    {
        $this->query->addJoin($alias ?
            sprintf("%s JOIN %s AS %s ON %s", $joinType, $joinedTable, $alias, $conditional) :
            sprintf("%s JOIN %s ON %s", $joinType, $joinedTable, $conditional));
        return $this;
    }

    public function where(string $field, string $operator, mixed $value): self
    {
        $this->query->addWhere(sprintf('%s %s "%s"', $field, $operator, $value));
        return $this;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->query->addOrderBy(sprintf("%s %s", $field, strtoupper($direction)));
        return $this;
    }

    public function groupBy(string $field): self
    {
        $this->query->addGroupBy($field);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->query->setLimit($limit);
        return $this;
    }

    public function addParams(array $params): self
    {
        foreach ($params as $key => $value) {
            $this->query->setParams([$key => $value]);
        }
        return $this;
    }

    public function insert(string $tableName, array $data): self
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($data) {
            return '"' . $data . '"';
        }, array_values($data)));
        $this->query->setInsert(sprintf('INSERT INTO %s (%s) VALUES (%s)', $tableName, $columns, $values));
        return $this;
    }

    public function update(string $tableName, array $data): self
    {
        $setPart = implode(", ", array_map(fn($key, $value) => "$key = '$value'", array_keys($data), array_values($data)));
        $this->query->setUpdate(sprintf("UPDATE %s SET %s", $tableName, $setPart));
        return $this;
    }

    public function getSelectQuery(): Query
    {
        $this->query->formatSelectQuery();
        return $this->query;
    }

    public function getDeleteQuery(): Query
    {
        $this->query->formatDeleteQuery();
        return $this->query;
    }

    public function getInsertQuery(): Query
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
