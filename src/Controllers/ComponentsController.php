<?php

namespace App\Controllers;

class ComponentsController
{
    public function index(): void
    {
        require __DIR__ . '/../../views/components.php';
    }
}
