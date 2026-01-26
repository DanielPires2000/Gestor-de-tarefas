<?php

namespace App\Core\ORM;

use App\Config\Database;
use PDO;

/**
 * Repositório base com operações CRUD genéricas usando o ORM
 */
abstract class BaseRepository
{
    protected PDO $db;
    protected QueryBuilder $queryBuilder;

    /**
     * Classe da entidade que este repositório gerencia
     * Deve ser definida nas classes filhas
     */
    protected string $entityClass = Entity::class;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Retorna o nome da tabela da entidade
     */
    protected function getTable(): string
    {
        return $this->entityClass::getTable();
    }

    /**
     * Retorna a chave primária da entidade
     */
    protected function getPrimaryKey(): string
    {
        return $this->entityClass::getPrimaryKey();
    }

    /**
     * Busca todos os registros
     */
    public function findAll(array $orderBy = []): array
    {
        $query = $this->queryBuilder
            ->reset()
            ->table($this->getTable())
            ->select();

        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $sql = $query->toSql();
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll();

        return array_map(
            fn($row) => $this->entityClass::fromArray($row),
            $rows
        );
    }

    /**
     * Busca um registro por ID
     */
    public function findById(int $id): ?Entity
    {
        $sql = $this->queryBuilder
            ->reset()
            ->table($this->getTable())
            ->select()
            ->where($this->getPrimaryKey(), $id)
            ->toSql();

        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->queryBuilder->getBindings());
        $row = $stmt->fetch();

        return $row ? $this->entityClass::fromArray($row) : null;
    }

    /**
     * Salva uma entidade (INSERT ou UPDATE)
     */
    public function save(Entity $entity): Entity
    {
        if ($entity->isNew()) {
            return $this->insert($entity);
        }
        return $this->update($entity);
    }

    /**
     * Insere nova entidade
     */
    protected function insert(Entity $entity): Entity
    {
        $data = $entity->toArray();
        unset($data[$this->getPrimaryKey()]); // Remove ID para auto-increment

        $sql = $this->queryBuilder
            ->reset()
            ->table($this->getTable())
            ->insert($data)
            ->toSql();

        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->queryBuilder->getBindings());

        $entity->id = (int) $this->db->lastInsertId();
        return $entity;
    }

    /**
     * Atualiza entidade existente
     */
    protected function update(Entity $entity): Entity
    {
        $data = $entity->toArray();
        $id = $data[$this->getPrimaryKey()];
        unset($data[$this->getPrimaryKey()]);

        $sql = $this->queryBuilder
            ->reset()
            ->table($this->getTable())
            ->update($data)
            ->where($this->getPrimaryKey(), $id)
            ->toSql();

        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->queryBuilder->getBindings());

        return $entity;
    }

    /**
     * Exclui um registro por ID
     */
    public function delete(int $id): bool
    {
        $sql = $this->queryBuilder
            ->reset()
            ->table($this->getTable())
            ->delete()
            ->where($this->getPrimaryKey(), $id)
            ->toSql();

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->queryBuilder->getBindings());
    }

    /**
     * Conta registros
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM " . $this->getTable());
        return (int) $stmt->fetchColumn();
    }
}
