<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - Gerenciador de Tarefas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e4e4e7;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
        }

        .error-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #f87171;
        }

        p {
            color: #9ca3af;
            margin-bottom: 2rem;
        }

        a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #a855f7, #6366f1);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }

        a:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Ops! Algo deu errado</h1>
        <p>Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.</p>
        <a href="/">← Voltar ao início</a>
    </div>
</body>

</html>