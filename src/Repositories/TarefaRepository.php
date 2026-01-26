<?php

namespace App\Repositories;

use App\Config\Database;
use App\Core\ORM\BaseRepository;
use App\Core\ORM\QueryBuilder;
use App\Entities\Tarefa;
use App\Interfaces\TarefaRepositoryInterface;
use Exception;
use PDO;

/**
 * Implementação do repositório de tarefas usando o ORM
 */
class TarefaRepository extends BaseRepository implements TarefaRepositoryInterface
{
    protected string $entityClass = Tarefa::class;

    /**
     * Lista todas as tarefas ordenadas por data de criação
     */
    public function listarTodas(): array
    {
        $tarefas = $this->findAll(['data_criacao' => 'DESC']);

        // Converte entidades para arrays para manter compatibilidade
        return array_map(fn($tarefa) => $tarefa->toArray(), $tarefas);
    }

    /**
     * Busca uma tarefa por ID
     */
    public function buscarPorId(int $id): ?array
    {
        $tarefa = $this->findById($id);
        return $tarefa ? $tarefa->toArray() : null;
    }

    /**
     * Salva uma nova tarefa
     * @throws Exception se o título estiver vazio
     */
    public function salvar(array $dados): int
    {
        $titulo = trim($dados['titulo'] ?? '');
        if (empty($titulo)) {
            throw new Exception('O título da tarefa é obrigatório.');
        }

        $tarefa = new Tarefa();
        $tarefa->titulo = $titulo;
        $tarefa->descricao = trim($dados['descricao'] ?? '');
        $tarefa->status = 'pendente';

        $savedTarefa = $this->save($tarefa);
        return $savedTarefa->id ?? 0;
    }

    /**
     * Marca uma tarefa como concluída
     * @throws Exception se a tarefa não existir
     */
    public function concluir(int $id): bool
    {
        $tarefa = $this->findById($id);
        if (!$tarefa) {
            throw new Exception('Tarefa não encontrada.');
        }

        /** @var Tarefa $tarefa */
        $tarefa->status = 'concluida';
        $this->save($tarefa);

        return true;
    }

    /**
     * Exclui uma tarefa
     */
    public function excluir(int $id): bool
    {
        return $this->delete($id);
    }
}
