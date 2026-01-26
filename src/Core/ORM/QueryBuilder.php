<?php

namespace App\Core\ORM;

/**
 * Query Builder fluente para construção de queries SQL
 */
class QueryBuilder
{
    private string $table = '';
    private string $type = 'SELECT';
    private array $columns = ['*'];
    private array $wheres = [];
    private array $orderBy = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private array $values = [];
    private array $bindings = [];

    /**
     * Define a tabela alvo
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Define colunas para SELECT
     */
    public function select(array $columns = ['*']): self
    {
        $this->type = 'SELECT';
        $this->columns = $columns;
        return $this;
    }

    /**
     * Prepara INSERT com dados
     */
    public function insert(array $data): self
    {
        $this->type = 'INSERT';
        $this->values = $data;
        return $this;
    }

    /**
     * Prepara UPDATE com dados
     */
    public function update(array $data): self
    {
        $this->type = 'UPDATE';
        $this->values = $data;
        return $this;
    }

    /**
     * Prepara DELETE
     */
    public function delete(): self
    {
        $this->type = 'DELETE';
        return $this;
    }

    /**
     * Adiciona condição WHERE
     */
    public function where(string $column, mixed $operator, mixed $value = null): self
    {
        // Suporta where('col', 'value') como where('col', '=', 'value')
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $placeholder = ':where_' . count($this->wheres) . '_' . $column;
        $this->wheres[] = "{$column} {$operator} {$placeholder}";
        $this->bindings[$placeholder] = $value;

        return $this;
    }

    /**
     * Adiciona ORDER BY
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy[] = "{$column} {$direction}";
        return $this;
    }

    /**
     * Define LIMIT
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Define OFFSET
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Constrói e retorna a query SQL
     */
    public function toSql(): string
    {
        return match ($this->type) {
            'SELECT' => $this->buildSelect(),
            'INSERT' => $this->buildInsert(),
            'UPDATE' => $this->buildUpdate(),
            'DELETE' => $this->buildDelete(),
            default => throw new \Exception("Tipo de query desconhecido: {$this->type}"),
        };
    }

    /**
     * Retorna os bindings para prepared statements
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    private function buildSelect(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . ' FROM ' . $this->table;
        $sql .= $this->buildWhere();
        $sql .= $this->buildOrderBy();
        $sql .= $this->buildLimit();
        return $sql;
    }

    private function buildInsert(): string
    {
        $columns = array_keys($this->values);
        $placeholders = [];

        foreach ($columns as $column) {
            $placeholder = ':' . $column;
            $placeholders[] = $placeholder;
            $this->bindings[$placeholder] = $this->values[$column];
        }

        return 'INSERT INTO ' . $this->table
            . ' (' . implode(', ', $columns) . ')'
            . ' VALUES (' . implode(', ', $placeholders) . ')';
    }

    private function buildUpdate(): string
    {
        $sets = [];

        foreach ($this->values as $column => $value) {
            $placeholder = ':set_' . $column;
            $sets[] = "{$column} = {$placeholder}";
            $this->bindings[$placeholder] = $value;
        }

        $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $sets);
        $sql .= $this->buildWhere();
        return $sql;
    }

    private function buildDelete(): string
    {
        return 'DELETE FROM ' . $this->table . $this->buildWhere();
    }

    private function buildWhere(): string
    {
        if (empty($this->wheres)) {
            return '';
        }
        return ' WHERE ' . implode(' AND ', $this->wheres);
    }

    private function buildOrderBy(): string
    {
        if (empty($this->orderBy)) {
            return '';
        }
        return ' ORDER BY ' . implode(', ', $this->orderBy);
    }

    private function buildLimit(): string
    {
        $sql = '';
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        if ($this->offset !== null) {
            $sql .= ' OFFSET ' . $this->offset;
        }
        return $sql;
    }

    /**
     * Reseta o builder para reutilização
     */
    public function reset(): self
    {
        $this->type = 'SELECT';
        $this->columns = ['*'];
        $this->wheres = [];
        $this->orderBy = [];
        $this->limit = null;
        $this->offset = null;
        $this->values = [];
        $this->bindings = [];
        return $this;
    }
}
