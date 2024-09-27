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

    public function from(string $tableName, string $alias=''): self
    {
        $this->query->setFrom($alias ? sprintf("%s AS %s", $tableName, $alias) : $tableName);
        return $this;
    }


    public function delete(string $tableName): self
    {
        $this->query->setDelete(sprintf('DELETE FROM %s', $tableName));
        return $this;
    }

    public function join(string $joinedTable, string $alias, string $conditional, string $joinType = 'INNER'): self
    {
        $this->query->addJoin(sprintf("%s JOIN %s AS %s ON %s", $joinType, $joinedTable, $alias, $conditional));
        return $this;
    }

    public function where(string $field, string $operator, mixed $value): self
    {
        $this->query->addWhere(sprintf("%s %s %s", $field, $operator, $value));
        return $this;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->query->addOrderBy(sprintf("%s %s", $field, strtoupper($direction)));
        return $this;
    }

    public function groupBys(string $field): self
    {
        $this->groupBys[] = $field;
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

    //Nie patrz na to 
    public static function insertInto(string $tableName, array $data): self
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));
        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $tableName, $fields, $placeholders);
        return new self($sql, $data);
    }

    public static function update(string $tableName, array $data, string $where): self
    {
        $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = sprintf("UPDATE %s SET %s WHERE %s", $tableName, $setPart, $where);
        return new self($sql, $data);
    }


}
