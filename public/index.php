<?php

/**
 * Gerenciador de Tarefas - Entry Point
 * 
 * Este arquivo serve como ponto de entrada e roteador simples
 */

// Iniciar sessão para mensagens flash
session_start();

// Autoload do Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\TarefaController;

// Instanciar controller
$controller = new TarefaController();

// Roteamento simples
$acao = $_GET['acao'] ?? 'index';

switch ($acao) {
    case 'nova':
        $controller->formulario();
        break;

    case 'salvar':
        $controller->salvar();
        break;

    case 'concluir':
        $controller->concluir();
        break;

    case 'excluir':
        $controller->excluir();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
