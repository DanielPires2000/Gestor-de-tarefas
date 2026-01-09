<?php

namespace App\Services;

use App\Interfaces\TarefaRepositoryInterface;
use Exception;

/**
 * Service responsável pela lógica de negócio de tarefas
 */
class TarefaService
{
    private TarefaRepositoryInterface $repository;

    public function __construct(TarefaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista todas as tarefas
     */
    public function listarTodas(): array
    {
        return $this->repository->listarTodas();
    }

    /**
     * Cria uma nova tarefa com validações de negócio
     */
    public function criar(array $dados): int
    {
        $titulo = trim($dados['titulo'] ?? '');

        if (strlen($titulo) < 3) {
            throw new Exception('O título deve ter pelo menos 3 caracteres.');
        }

        if (strlen($titulo) > 100) {
            throw new Exception('O título não pode ter mais de 100 caracteres.');
        }

        return $this->repository->salvar($dados);
    }

    /**
     * Conclui uma tarefa
     */
    public function concluir(int $id): bool
    {
        $tarefa = $this->repository->buscarPorId($id);

        if (!$tarefa) {
            throw new Exception('Tarefa não encontrada.');
        }

        if ($tarefa['status'] === 'concluida') {
            throw new Exception('Esta tarefa já está concluída.');
        }

        return $this->repository->concluir($id);
    }

    /**
     * Exclui uma tarefa
     */
    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }
}
