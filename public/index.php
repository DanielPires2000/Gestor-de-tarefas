<?php

/**
 * Gerenciador de Tarefas - Entry Point
 */

session_start();

require __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis do .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar ambiente
$isDebug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';

// Configurar exibição de erros baseado no ambiente
if ($isDebug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

use App\Config\Container;
use App\Config\Logger;
use App\Config\ErrorHandler;
use App\Core\Router;
use App\Interfaces\TarefaRepositoryInterface;
use App\Repositories\TarefaRepository;
use App\Services\TarefaService;
use App\Controllers\TarefaController;
use App\Controllers\DocsController;
use App\Controllers\ComponentsController;

// Registrar handler global de erros
$logger = Logger::getInstance();
$errorHandler = new ErrorHandler($logger, $isDebug);
$errorHandler->register();

// Configurar Container de DI
$container = new Container();

$container->singleton(TarefaRepositoryInterface::class, fn() => new TarefaRepository());

$container->singleton(TarefaService::class, fn($c) => new TarefaService($c->get(TarefaRepositoryInterface::class)));

$container->singleton(TarefaController::class, fn($c) => new TarefaController($c->get(TarefaService::class)));

$container->singleton(DocsController::class, fn() => new DocsController());

$container->singleton(ComponentsController::class, fn() => new ComponentsController());

// Roteamento Dinâmico
$router = new Router($container);
$router->dispatch($_SERVER['REQUEST_URI']);
