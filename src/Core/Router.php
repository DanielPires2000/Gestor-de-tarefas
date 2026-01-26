<?php

namespace App\Core;

use App\Config\Container;
use Exception;

/**
 * Router dinâmico que resolve rotas baseado em convenções
 * Padrão: /{controller}/{action}/{id?}
 */
class Router
{
    private Container $container;
    private string $defaultController = 'tarefa';
    private string $defaultAction = 'index';
    private string $controllerNamespace = 'App\\Controllers\\';

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Despacha a requisição para o controller apropriado
     */
    public function dispatch(string $uri): void
    {
        // Parse da URI
        $parsed = $this->parseUri($uri);

        $controllerName = $parsed['controller'];
        $action = $parsed['action'];
        $id = $parsed['id'];

        // Resolve o controller
        $controllerClass = $this->resolveControllerClass($controllerName);

        if (!class_exists($controllerClass)) {
            throw new Exception("Controller não encontrado: {$controllerClass}", 404);
        }

        // Obtém controller do Container
        $controller = $this->container->get($controllerClass);

        // Verifica se o método existe
        if (!method_exists($controller, $action)) {
            throw new Exception("Ação não encontrada: {$controllerClass}::{$action}", 404);
        }

        // Executa a ação
        if ($id !== null) {
            $controller->$action($id);
        } else {
            $controller->$action();
        }
    }

    /**
     * Faz parse da URI e extrai controller, action e id
     */
    private function parseUri(string $uri): array
    {
        // Remove query string
        $path = parse_url($uri, PHP_URL_PATH);

        // Remove /index.php se presente
        $path = preg_replace('#^/index\.php#', '', $path);

        // Remove barras iniciais/finais
        $path = trim($path, '/');

        // Mantém compatibilidade com ?acao= style
        if (empty($path) && isset($_GET['acao'])) {
            return [
                'controller' => $this->defaultController,
                'action' => $this->mapLegacyAction($_GET['acao']),
                'id' => isset($_GET['id']) ? (int) $_GET['id'] : null,
            ];
        }

        // Parse segmentos: /controller/action/id
        $segments = $path ? explode('/', $path) : [];

        return [
            'controller' => $segments[0] ?? $this->defaultController,
            'action' => $segments[1] ?? $this->defaultAction,
            'id' => isset($segments[2]) ? (int) $segments[2] : null,
        ];
    }

    /**
     * Mapeia ações legadas para novos nomes de métodos
     */
    private function mapLegacyAction(string $acao): string
    {
        $map = [
            'nova' => 'formulario',
            'salvar' => 'salvar',
            'concluir' => 'concluir',
            'excluir' => 'excluir',
            'index' => 'index',
        ];

        return $map[$acao] ?? $acao;
    }

    /**
     * Resolve o nome completo da classe do controller
     */
    private function resolveControllerClass(string $name): string
    {
        // Converte para PascalCase e adiciona sufixo Controller
        $className = ucfirst(strtolower($name)) . 'Controller';
        return $this->controllerNamespace . $className;
    }

    /**
     * Define o controller padrão
     */
    public function setDefaultController(string $controller): self
    {
        $this->defaultController = $controller;
        return $this;
    }

    /**
     * Define a action padrão
     */
    public function setDefaultAction(string $action): self
    {
        $this->defaultAction = $action;
        return $this;
    }
}
