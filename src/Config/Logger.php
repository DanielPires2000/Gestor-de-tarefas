<?php

namespace App\Config;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Psr\Log\LoggerInterface;

/**
 * Configuração centralizada de logging
 */
class Logger
{
    private static ?LoggerInterface $instance = null;

    public static function getInstance(): LoggerInterface
    {
        if (self::$instance === null) {
            $logger = new MonologLogger('app');

            // Formato personalizado
            $formatter = new LineFormatter(
                "[%datetime%] %channel%.%level_name%: %message% %context%\n",
                "Y-m-d H:i:s"
            );

            // Handler para arquivo rotativo (máx 7 dias)
            $handler = new RotatingFileHandler(
                __DIR__ . '/../../logs/app.log',
                7,
                MonologLogger::DEBUG
            );
            $handler->setFormatter($formatter);

            $logger->pushHandler($handler);

            // Em desenvolvimento, também loga erros no stderr
            if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
                $stderrHandler = new StreamHandler('php://stderr', MonologLogger::ERROR);
                $stderrHandler->setFormatter($formatter);
                $logger->pushHandler($stderrHandler);
            }

            self::$instance = $logger;
        }

        return self::$instance;
    }
}
