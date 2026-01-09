<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - Debug</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Fira Code', 'Consolas', monospace;
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 2rem;
            line-height: 1.6;
        }

        .header {
            background: #b91c1c;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header h1 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .content {
            background: #2d2d2d;
            padding: 1.5rem;
            border-radius: 0 0 8px 8px;
        }

        .section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            color: #569cd6;
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .message {
            background: #3c3c3c;
            padding: 1rem;
            border-radius: 6px;
            border-left: 4px solid #b91c1c;
            font-size: 1rem;
            color: #f87171;
        }

        .file {
            color: #9cdcfe;
            font-size: 0.9rem;
        }

        .line {
            color: #ce9178;
        }

        .trace {
            background: #1e1e1e;
            padding: 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            overflow-x: auto;
            white-space: pre-wrap;
            max-height: 400px;
            overflow-y: auto;
        }

        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #569cd6;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <span style="font-size: 1.5rem;">🐛</span>
        <h1>
            <?= htmlspecialchars(get_class($e)) ?>
        </h1>
    </div>
    <div class="content">
        <div class="section">
            <div class="section-title">Mensagem</div>
            <div class="message">
                <?= htmlspecialchars($e->getMessage()) ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Localização</div>
            <div class="file">
                <?= htmlspecialchars($e->getFile()) ?>:<span class="line">
                    <?= $e->getLine() ?>
                </span>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Stack Trace</div>
            <div class="trace">
                <?= htmlspecialchars($e->getTraceAsString()) ?>
            </div>
        </div>

        <a href="/" class="back-link">← Voltar ao início</a>
    </div>
</body>

</html>