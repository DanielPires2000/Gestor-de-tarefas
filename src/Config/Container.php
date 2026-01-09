<?php

namespace App\Config;

use Exception;

/**
 * Container de Injeção de Dependência simples
 */
class Container
{
    private array $bindings = [];
    private array $instances = [];

    /**
     * Registra como criar uma dependência
     */
    public function bind(string $abstract, callable $factory): void
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     * Registra um singleton (instância única)
     */
    public function singleton(string $abstract, callable $factory): void
    {
        $this->bindings[$abstract] = function ($container) use ($abstract, $factory) {
            if (!isset($this->instances[$abstract])) {
                $this->instances[$abstract] = $factory($container);
            }
            return $this->instances[$abstract];
        };
    }

    /**
     * Resolve uma dependência
     */
    public function get(string $abstract): mixed
    {
        if (!isset($this->bindings[$abstract])) {
            throw new Exception("Dependência não registrada: {$abstract}");
        }

        return $this->bindings[$abstract]($this);
    }

    /**
     * Verifica se uma dependência está registrada
     */
    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }
}
