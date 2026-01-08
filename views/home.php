<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: #e4e4e7;
            padding: 2rem;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            background: linear-gradient(90deg, #00d9ff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #9ca3af;
            font-size: 1rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .actions-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
        }

        .btn-success {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .btn-success:hover {
            background: rgba(34, 197, 94, 0.3);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem 1.25rem;
            text-align: left;
        }

        th {
            background: rgba(255, 255, 255, 0.03);
            font-weight: 600;
            color: #9ca3af;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.2s ease;
        }

        tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pendente {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        .status-concluida {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
        }

        .task-title {
            font-weight: 600;
            color: #f4f4f5;
        }

        .task-title.concluida {
            text-decoration: line-through;
            color: #6b7280;
        }

        .task-desc {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        .task-date {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .actions-cell {
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>📋 Gerenciador de Tarefas</h1>
            <p class="subtitle">Organize suas atividades de forma simples e elegante</p>
        </header>

        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success">
                ✅
                <?= htmlspecialchars($sucesso) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error">
                ❌
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <div class="actions-bar">
            <a href="index.php?acao=nova" class="btn btn-primary">
                ➕ Nova Tarefa
            </a>
        </div>

        <div class="card">
            <?php if (empty($tarefas)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h3>Nenhuma tarefa encontrada</h3>
                    <p>Clique em "Nova Tarefa" para começar!</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tarefa</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarefas as $tarefa): ?>
                            <tr>
                                <td>
                                    <div class="task-title <?= $tarefa['status'] === 'concluida' ? 'concluida' : '' ?>">
                                        <?= htmlspecialchars($tarefa['titulo']) ?>
                                    </div>
                                    <?php if (!empty($tarefa['descricao'])): ?>
                                        <div class="task-desc">
                                            <?= htmlspecialchars($tarefa['descricao']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= $tarefa['status'] ?>">
                                        <?= $tarefa['status'] === 'concluida' ? '✓ Concluída' : '⏳ Pendente' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="task-date">
                                        <?= date('d/m/Y H:i', strtotime($tarefa['data_criacao'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <?php if ($tarefa['status'] !== 'concluida'): ?>
                                            <a href="index.php?acao=concluir&id=<?= $tarefa['id'] ?>" class="btn btn-success btn-sm"
                                                title="Marcar como concluída">
                                                ✓
                                            </a>
                                        <?php endif; ?>
                                        <a href="index.php?acao=excluir&id=<?= $tarefa['id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"
                                            title="Excluir tarefa">
                                            🗑
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>