<?php

namespace app;

class Query
{
    private string $statement = '';
    private string $select = '';
    private string $delete = '';
    private string $insert = '';
    private string $update = '';
    private string $from = '';
    private array $joins = [];
    private array $wheres = [];
    private array $orderBys = [];
    private array $groupBys = [];
    private ?int $limit = null;

    public function __construct()
    {

    }
    public function showStatement(): string
    {
        return $this->statement;
    }

    /**
     * @param string $select
     */
    public function setSelect(string $select): void
    {
        $this->select = $select;
    }

    /**
     * @param string $delete
     */
    public function setDelete(string $delete): void
    {
        $this->delete = $delete;
    }

    /**
     * @param array $joins
     */
    public function addJoin(string $join): void
    {
        $this->joins[] = $join;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @param array $wheres
     */
    public function addWhere(string $where): void
    {
        $this->wheres[] = $where;
    }

    /**
     * @param array $orderBys
     */
    public function addOrderBy(string $orderBy): void
    {
        $this->orderBys[] = $orderBy;
    }

    /**
     * @param array $groupBys
     */
    public function addGroupBy(string $field): void
    {
        $this->groupBys[] = $field;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @param string $insert
     */
    public function setInsert(string $insert): void
    {
        $this->insert = $insert;
    }

    /**
     * @param string $update
     */
    public function setUpdate(string $update): void
    {
        $this->update = $update;
    }
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function formatSelectQuery()
    {
        $joinPart = implode(' ', $this->joins);
        $wherePart = count($this->wheres) > 0 ? ' WHERE ' . implode(' AND ', $this->wheres) : '';
        $groupByPart = count($this->groupBys) > 0 ? ' GROUP BY ' . implode(', ', $this->groupBys) : '';
        $orderByPart = count($this->orderBys) > 0 ? ' ORDER BY ' . implode(', ', $this->orderBys) : '';
        $limitPart = $this->limit !== null ? ' LIMIT ' . $this->limit : '';

        $this->statement = sprintf("%s %s %s%s%s%s%s", $this->select, $this->from, $wherePart, $joinPart, $groupByPart, $orderByPart, $limitPart);
    }
    public function formatDeleteQuery()
    {
        $wherePart = count($this->wheres) > 0 ? implode(' AND ', $this->wheres) : '';
        $this->statement = sprintf("%s %s %s", $this->delete, $this->from, $wherePart);
    }

    public function formatInsertQuery()
    {
        $this->statement = $this->insert;
    }

    public function formatUpdateQuery()
    {
        $wherePart = count($this->wheres) > 0 ? ' WHERE ' . implode(' AND ', $this->wheres) : '';
        $this->statement = sprintf("%s %s", $this->update, $wherePart);


    }




}
