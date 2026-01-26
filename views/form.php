<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Tarefa - Gerenciador de Tarefas</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 1.75rem;
            background: linear-gradient(90deg, #00d9ff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: shake 0.4s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 0.5rem;
        }

        .required {
            color: #f87171;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.9rem 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #f4f4f5;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        input[type="text"]::placeholder,
        textarea::placeholder {
            color: #6b7280;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
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

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #9ca3af;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #f4f4f5;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #a855f7;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="card">
            <header>
                <h1>✨ Nova Tarefa</h1>
                <p class="subtitle">Adicione uma nova tarefa à sua lista</p>
            </header>

            <?php if (!empty($erro)): ?>
                <div class="alert alert-error">
                    ❌
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="/tarefa/salvar" method="POST">
                <div class="form-group">
                    <label for="titulo">
                        Título <span class="required">*</span>
                    </label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Estudar PHP"
                        value="<?= htmlspecialchars($dados['titulo'] ?? '') ?>" autofocus>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao"
                        placeholder="Detalhes opcionais sobre a tarefa..."><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                </div>

                <div class="btn-group">
                    <a href="/tarefa" class="btn btn-secondary">
                        ← Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Salvar Tarefa
                    </button>
                </div>
            </form>
        </div>

        <a href="/tarefa" class="back-link">← Voltar para a lista de tarefas</a>
    </div>
</body>

</html>