<?php

namespace App\Core\ORM;

use ReflectionClass;
use ReflectionProperty;

/**
 * Classe base para todas as entidades do ORM
 */
abstract class Entity
{
    /**
     * Nome da tabela no banco de dados
     */
    protected static string $table = '';

    /**
     * Chave primária da tabela
     */
    protected static string $primaryKey = 'id';

    /**
     * Propriedade de ID (comum a todas as entidades)
     */
    public ?int $id = null;

    /**
     * Retorna o nome da tabela
     */
    public static function getTable(): string
    {
        return static::$table;
    }

    /**
     * Retorna o nome da chave primária
     */
    public static function getPrimaryKey(): string
    {
        return static::$primaryKey;
    }

    /**
     * Retorna os nomes das colunas mapeáveis (propriedades públicas)
     */
    public static function getColumns(): array
    {
        $reflection = new ReflectionClass(static::class);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        return array_map(fn($prop) => $prop->getName(), $properties);
    }

    /**
     * Converte a entidade para array
     */
    public function toArray(): array
    {
        $data = [];
        foreach (static::getColumns() as $column) {
            if (isset($this->$column)) {
                $data[$column] = $this->$column;
            }
        }
        return $data;
    }

    /**
     * Preenche a entidade a partir de um array
     */
    public static function fromArray(array $data): static
    {
        $entity = new static();
        foreach (static::getColumns() as $column) {
            if (array_key_exists($column, $data)) {
                $entity->$column = $data[$column];
            }
        }
        return $entity;
    }

    /**
     * Verifica se a entidade é nova (não foi persistida ainda)
     */
    public function isNew(): bool
    {
        return $this->id === null;
    }
}
