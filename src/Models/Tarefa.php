<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class Tarefa
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Lista todas as tarefas ordenadas por data de criação
     */
    public function listarTodas(): array
    {
        $stmt = $this->db->query("SELECT * FROM tarefas ORDER BY data_criacao DESC");
        return $stmt->fetchAll();
    }

    /**
     * Busca uma tarefa por ID
     */
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM tarefas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $tarefa = $stmt->fetch();
        return $tarefa ?: null;
    }

    /**
     * Salva uma nova tarefa
     * @throws Exception se o título estiver vazio
     */
    public function salvar(array $dados): int
    {
        // Regra: Não aceitar tarefas sem título
        $titulo = trim($dados['titulo'] ?? '');
        if (empty($titulo)) {
            throw new Exception('O título da tarefa é obrigatório.');
        }

        $descricao = trim($dados['descricao'] ?? '');

        $stmt = $this->db->prepare(
            "INSERT INTO tarefas (titulo, descricao, status) VALUES (:titulo, :descricao, 'pendente')"
        );

        $stmt->execute([
            'titulo' => $titulo,
            'descricao' => $descricao
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Marca uma tarefa como concluída
     * @throws Exception se a tarefa não existir
     */
    public function concluir(int $id): bool
    {
        // Regra: Só é possível concluir uma tarefa que existe
        $tarefa = $this->buscarPorId($id);
        if (!$tarefa) {
            throw new Exception('Tarefa não encontrada.');
        }

        $stmt = $this->db->prepare(
            "UPDATE tarefas SET status = 'concluida' WHERE id = :id"
        );

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Exclui uma tarefa
     */
    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tarefas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
