<?php

/**
 * Gerenciador de Tarefas - Entry Point
 * 
 * Este arquivo serve como ponto de entrada e roteador simples
 */

// Iniciar sessão para mensagens flash
session_start();

// Autoload simples
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

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
