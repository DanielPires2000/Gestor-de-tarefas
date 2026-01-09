<?php

namespace App\Controllers;

use App\Services\TarefaService;
use Exception;

class TarefaController
{
    private TarefaService $service;

    public function __construct(TarefaService $service)
    {
        $this->service = $service;
    }

    /**
     * Lista todas as tarefas (Home)
     */
    public function index(): void
    {
        $tarefas = $this->service->listarTodas();
        $erro = $_SESSION['erro'] ?? null;
        $sucesso = $_SESSION['sucesso'] ?? null;

        unset($_SESSION['erro'], $_SESSION['sucesso']);

        require __DIR__ . '/../../views/home.php';
    }

    /**
     * Exibe o formulário de nova tarefa
     */
    public function formulario(): void
    {
        $erro = $_SESSION['erro'] ?? null;
        $dados = $_SESSION['dados'] ?? [];

        unset($_SESSION['erro'], $_SESSION['dados']);

        require __DIR__ . '/../../views/form.php';
    }

    /**
     * Salva uma nova tarefa (POST)
     */
    public function salvar(): void
    {
        try {
            $this->service->criar($_POST);
            $_SESSION['sucesso'] = 'Tarefa criada com sucesso!';
            header('Location: index.php');
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            $_SESSION['dados'] = $_POST;
            header('Location: index.php?acao=nova');
        }
        exit;
    }

    /**
     * Marca tarefa como concluída
     */
    public function concluir(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->service->concluir($id);
                $_SESSION['sucesso'] = 'Tarefa concluída!';
            } catch (Exception $e) {
                $_SESSION['erro'] = $e->getMessage();
            }
        }

        header('Location: index.php');
        exit;
    }

    /**
     * Exclui uma tarefa
     */
    public function excluir(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->service->excluir($id);
                $_SESSION['sucesso'] = 'Tarefa excluída!';
            } catch (Exception $e) {
                $_SESSION['erro'] = $e->getMessage();
            }
        }

        header('Location: index.php');
        exit;
    }
}
