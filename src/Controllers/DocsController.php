<?php

namespace App\Controllers;

use OpenApi\Generator;

/**
 * Controller para documentação Swagger/OpenAPI
 */
class DocsController
{
    /**
     * Exibe a UI do Swagger
     */
    public function index(): void
    {
        require __DIR__ . '/../../views/docs.php';
    }

    /**
     * Retorna o JSON OpenAPI
     */
    public function json(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $openapi = Generator::scan([
            __DIR__ . '/../Controllers',
            __DIR__ . '/../Entities',
        ]);

        echo $openapi->toJson();
    }
}
