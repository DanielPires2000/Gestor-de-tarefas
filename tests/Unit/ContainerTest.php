<?php

namespace Tests\Unit;

use App\Config\Container;
use PHPUnit\Framework\TestCase;
use Exception;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testBindEResolve(): void
    {
        $this->container->bind('test', fn() => 'valor');

        $result = $this->container->get('test');

        $this->assertEquals('valor', $result);
    }

    public function testSingletonRetornaMesmaInstancia(): void
    {
        $this->container->singleton('counter', function () {
            return new class {
                public int $count = 0;
            };
        });

        $instance1 = $this->container->get('counter');
        $instance1->count = 5;

        $instance2 = $this->container->get('counter');

        $this->assertSame($instance1, $instance2);
        $this->assertEquals(5, $instance2->count);
    }

    public function testHas(): void
    {
        $this->assertFalse($this->container->has('inexistente'));

        $this->container->bind('existente', fn() => true);

        $this->assertTrue($this->container->has('existente'));
    }

    public function testGetDependenciaNaoRegistradaLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Dependência não registrada: inexistente');

        $this->container->get('inexistente');
    }

    public function testDependencyInjectionEncadeada(): void
    {
        $this->container->singleton('config', fn() => ['db' => 'postgres']);

        $this->container->singleton('database', fn($c) => [
            'connection' => $c->get('config')['db']
        ]);

        $db = $this->container->get('database');

        $this->assertEquals('postgres', $db['connection']);
    }
}
