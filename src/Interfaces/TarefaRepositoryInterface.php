<?php

namespace App\Interfaces;

/**
 * Interface para repositório de tarefas
 * Define o contrato que qualquer implementação de repositório de tarefas deve seguir
 */
interface TarefaRepositoryInterface
{
    /**
     * Lista todas as tarefas
     * @return array Lista de tarefas
     */
    public function listarTodas(): array;

    /**
     * Busca uma tarefa por ID
     * @param int $id ID da tarefa
     * @return array|null Tarefa encontrada ou null
     */
    public function buscarPorId(int $id): ?array;

    /**
     * Salva uma nova tarefa
     * @param array $dados Dados da tarefa
     * @return int ID da tarefa criada
     */
    public function salvar(array $dados): int;

    /**
     * Marca uma tarefa como concluída
     * @param int $id ID da tarefa
     * @return bool Sucesso da operação
     */
    public function concluir(int $id): bool;

    /**
     * Exclui uma tarefa
     * @param int $id ID da tarefa
     * @return bool Sucesso da operação
     */
    public function excluir(int $id): bool;
}
