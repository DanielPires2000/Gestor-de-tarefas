<?php

namespace App\Config;

use Throwable;
use Psr\Log\LoggerInterface;

/**
 * Handler global de exceções e erros
 */
class ErrorHandler
{
    private LoggerInterface $logger;
    private bool $debug;

    public function __construct(LoggerInterface $logger, bool $debug = false)
    {
        $this->logger = $logger;
        $this->debug = $debug;
    }

    /**
     * Registra os handlers globais
     */
    public function register(): void
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Trata exceções não capturadas
     */
    public function handleException(Throwable $e): void
    {
        $this->logger->error($e->getMessage(), [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        $this->renderErrorPage($e);
    }

    /**
     * Converte erros PHP em exceções
     */
    public function handleError(int $level, string $message, string $file, int $line): bool
    {
        if (!(error_reporting() & $level)) {
            return false;
        }

        $this->logger->warning("PHP Error: {$message}", [
            'level' => $level,
            'file' => $file,
            'line' => $line
        ]);

        throw new \ErrorException($message, 0, $level, $file, $line);
    }

    /**
     * Trata erros fatais no shutdown
     */
    public function handleShutdown(): void
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
            $this->logger->critical("Fatal Error: {$error['message']}", [
                'type' => $error['type'],
                'file' => $error['file'],
                'line' => $error['line']
            ]);

            $this->renderErrorPage(new \ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            ));
        }
    }

    /**
     * Renderiza página de erro
     */
    private function renderErrorPage(Throwable $e): void
    {
        http_response_code(500);

        if ($this->debug) {
            // Modo desenvolvimento: mostra detalhes
            require __DIR__ . '/../../views/error_debug.php';
        } else {
            // Modo produção: página genérica
            require __DIR__ . '/../../views/error.php';
        }

        exit(1);
    }
}
