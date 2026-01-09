<?php

require __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis de ambiente para testes
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Configurar ambiente de teste
$_ENV['APP_ENV'] = 'testing';
$_ENV['APP_DEBUG'] = 'true';
