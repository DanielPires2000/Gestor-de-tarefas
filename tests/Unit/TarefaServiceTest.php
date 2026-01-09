<?php

namespace Tests\Unit;

use App\Services\TarefaService;
use App\Interfaces\TarefaRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Exception;

class TarefaServiceTest extends TestCase
{
    private TarefaService $service;
    private TarefaRepositoryInterface $mockRepository;

    protected function setUp(): void
    {
        // Mock da Interface - simples e limpo!
        $this->mockRepository = $this->createMock(TarefaRepositoryInterface::class);
        $this->service = new TarefaService($this->mockRepository);
    }

    public function testCriarTarefaComTituloValido(): void
    {
        $dados = ['titulo' => 'Tarefa de Teste', 'descricao' => 'Descrição'];

        $this->mockRepository
            ->expects($this->once())
            ->method('salvar')
            ->with($dados)
            ->willReturn(1);

        $id = $this->service->criar($dados);

        $this->assertEquals(1, $id);
    }

    public function testCriarTarefaSemTituloLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('O título deve ter pelo menos 3 caracteres.');

        $this->service->criar(['titulo' => '']);
    }

    public function testCriarTarefaComTituloCurtoLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('O título deve ter pelo menos 3 caracteres.');

        $this->service->criar(['titulo' => 'AB']);
    }

    public function testCriarTarefaComTituloLongoLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('O título não pode ter mais de 100 caracteres.');

        $tituloLongo = str_repeat('A', 101);
        $this->service->criar(['titulo' => $tituloLongo]);
    }

    public function testConcluirTarefaExistente(): void
    {
        $this->mockRepository
            ->expects($this->once())
            ->method('buscarPorId')
            ->with(1)
            ->willReturn(['id' => 1, 'status' => 'pendente']);

        $this->mockRepository
            ->expects($this->once())
            ->method('concluir')
            ->with(1)
            ->willReturn(true);

        $result = $this->service->concluir(1);

        $this->assertTrue($result);
    }

    public function testConcluirTarefaInexistenteLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Tarefa não encontrada.');

        $this->mockRepository
            ->expects($this->once())
            ->method('buscarPorId')
            ->with(999)
            ->willReturn(null);

        $this->service->concluir(999);
    }

    public function testConcluirTarefaJaConcluidaLancaExcecao(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Esta tarefa já está concluída.');

        $this->mockRepository
            ->expects($this->once())
            ->method('buscarPorId')
            ->with(1)
            ->willReturn(['id' => 1, 'status' => 'concluida']);

        $this->service->concluir(1);
    }

    public function testListarTodas(): void
    {
        $tarefas = [
            ['id' => 1, 'titulo' => 'Tarefa 1'],
            ['id' => 2, 'titulo' => 'Tarefa 2'],
        ];

        $this->mockRepository
            ->expects($this->once())
            ->method('listarTodas')
            ->willReturn($tarefas);

        $result = $this->service->listarTodas();

        $this->assertCount(2, $result);
        $this->assertEquals('Tarefa 1', $result[0]['titulo']);
    }

    public function testExcluirTarefa(): void
    {
        $this->mockRepository
            ->expects($this->once())
            ->method('excluir')
            ->with(1)
            ->willReturn(true);

        $result = $this->service->excluir(1);

        $this->assertTrue($result);
    }
}
