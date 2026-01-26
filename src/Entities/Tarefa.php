<?php

namespace App\Entities;

use App\Core\ORM\Entity;
use OpenApi\Attributes as OA;

/**
 * Entidade Tarefa
 */
#[OA\Schema(
    schema: "Tarefa",
    title: "Tarefa",
    description: "Representa uma tarefa no sistema",
    required: ["titulo"]
)]
class Tarefa extends Entity
{
    protected static string $table = 'tarefas';
    protected static string $primaryKey = 'id';

    #[OA\Property(description: "ID único da tarefa", example: 1)]
    public ?int $id = null;

    #[OA\Property(description: "Título da tarefa", example: "Estudar PHP", minLength: 3, maxLength: 100)]
    public string $titulo = '';

    #[OA\Property(description: "Descrição detalhada da tarefa", example: "Aprender sobre ORM e Swagger")]
    public ?string $descricao = null;

    #[OA\Property(description: "Status da tarefa", example: "pendente", enum: ["pendente", "concluida"])]
    public string $status = 'pendente';

    #[OA\Property(description: "Data de criação", example: "2026-01-09 19:56:00")]
    public ?string $data_criacao = null;
}
