<?php

namespace App\Controllers;

use App\Models\Tarefa;
use Exception;

class TarefaController
{
    private Tarefa $model;

    public function __construct()
    {
        $this->model = new Tarefa();
    }

    /**
     * Cenário A: Lista todas as tarefas (Home)
     */
    public function index(): void
    {
        $tarefas = $this->model->listarTodas();
        $erro = $_SESSION['erro'] ?? null;
        $sucesso = $_SESSION['sucesso'] ?? null;

        // Limpar mensagens da sessão
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

        // Limpar dados da sessão
        unset($_SESSION['erro'], $_SESSION['dados']);

        require __DIR__ . '/../../views/form.php';
    }

    /**
     * Cenário B: Salva uma nova tarefa (POST)
     */
    public function salvar(): void
    {
        try {
            $this->model->salvar($_POST);
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
     * Cenário C: Marca tarefa como concluída
     */
    public function concluir(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->model->concluir($id);
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
            $this->model->excluir($id);
            $_SESSION['sucesso'] = 'Tarefa excluída!';
        }

        header('Location: index.php');
        exit;
    }
}
