<?php

namespace App\Controllers;

use App\Services\TarefaService;
use Exception;
use OpenApi\Attributes as OA;

/**
 * Controller de Tarefas
 */
#[OA\Info(
    version: "1.0.0",
    title: "Gerenciador de Tarefas API",
    description: "API para gestão de tarefas com operações CRUD"
)]
#[OA\Server(url: "http://localhost:8080", description: "Servidor de Desenvolvimento")]
#[OA\Tag(name: "Tarefas", description: "Operações de gestão de tarefas")]
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
    #[OA\Get(
        path: "/tarefa",
        summary: "Lista todas as tarefas",
        tags: ["Tarefas"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de tarefas",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Tarefa")
                )
            )
        ]
    )]
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
    #[OA\Get(
        path: "/tarefa/formulario",
        summary: "Exibe formulário para criar nova tarefa",
        tags: ["Tarefas"],
        responses: [
            new OA\Response(response: 200, description: "Formulário HTML")
        ]
    )]
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
    #[OA\Post(
        path: "/tarefa/salvar",
        summary: "Cria uma nova tarefa",
        tags: ["Tarefas"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["titulo"],
                properties: [
                    new OA\Property(property: "titulo", type: "string", description: "Título da tarefa (3-100 caracteres)"),
                    new OA\Property(property: "descricao", type: "string", description: "Descrição opcional")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: "Redireciona para lista de tarefas"),
            new OA\Response(response: 400, description: "Dados inválidos")
        ]
    )]

    public function salvar(): void
    {
        try {
            $this->service->criar($_POST);
            $_SESSION['sucesso'] = 'Tarefa criada com sucesso!';
            header('Location: /tarefa');
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            $_SESSION['dados'] = $_POST;
            header('Location: /tarefa/formulario');
        }
        exit;
    }

    /**
     * Marca tarefa como concluída
     */
    #[OA\Get(
        path: "/tarefa/concluir/{id}",
        summary: "Marca uma tarefa como concluída",
        tags: ["Tarefas"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID da tarefa",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 302, description: "Redireciona para lista de tarefas"),
            new OA\Response(response: 404, description: "Tarefa não encontrada")
        ]
    )]
    public function concluir(?int $id = null): void
    {
        // Suporte a ID via parâmetro ou query string (retrocompatibilidade)
        $id = $id ?? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->service->concluir($id);
                $_SESSION['sucesso'] = 'Tarefa concluída!';
            } catch (Exception $e) {
                $_SESSION['erro'] = $e->getMessage();
            }
        }

        header('Location: /tarefa');
        exit;
    }

    /**
     * Exclui uma tarefa
     */
    #[OA\Delete(
        path: "/tarefa/excluir/{id}",
        summary: "Exclui uma tarefa",
        tags: ["Tarefas"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID da tarefa",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 302, description: "Redireciona para lista de tarefas"),
            new OA\Response(response: 404, description: "Tarefa não encontrada")
        ]
    )]
    public function excluir(?int $id = null): void
    {
        // Suporte a ID via parâmetro ou query string (retrocompatibilidade)
        $id = $id ?? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->service->excluir($id);
                $_SESSION['sucesso'] = 'Tarefa excluída!';
            } catch (Exception $e) {
                $_SESSION['erro'] = $e->getMessage();
            }
        }

        header('Location: /tarefa');
        exit;
    }
}
