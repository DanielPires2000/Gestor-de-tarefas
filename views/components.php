<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Estilos e Componentes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Colors */
            --bg-body: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.7);
            --bg-hover: rgba(255, 255, 255, 0.05);

            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --secondary: #0ea5e9;

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;

            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: rgba(148, 163, 184, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            min-height: 100vh;
            color: var(--text-main);
            padding: 2rem;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            margin-bottom: 4rem;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(to right, #c084fc, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-main);
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Grid for showcase */
        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-color: rgba(148, 163, 184, 0.2);
        }

        /* Buttons */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-success {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        /* Typography */
        .typography-sample {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: white;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-primary {
            background: rgba(139, 92, 246, 0.2);
            color: #a78bfa;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        /* Code snippets */
        /* Custom Select */
        .custom-select-wrapper {
            position: relative;
            user-select: none;
            width: 100%;
        }

        .custom-select {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .custom-select-trigger {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-select-trigger:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(148, 163, 184, 0.3);
        }

        .custom-select.open .custom-select-trigger {
            border-color: var(--primary);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .arrow {
            position: relative;
            height: 10px;
            width: 10px;
        }

        .arrow::before,
        .arrow::after {
            content: "";
            position: absolute;
            bottom: 0px;
            width: 0.15rem;
            height: 100%;
            transition: all 0.2s;
            background-color: var(--text-muted);
        }

        .arrow::before {
            left: -3px;
            transform: rotate(-45deg);
        }

        .arrow::after {
            left: 3px;
            transform: rotate(45deg);
        }

        .open .arrow::before {
            left: -3px;
            transform: rotate(45deg);
        }

        .open .arrow::after {
            left: 3px;
            transform: rotate(-45deg);
        }

        .custom-options {
            position: absolute;
            display: block;
            top: 100%;
            left: 0;
            right: 0;
            border: 1px solid var(--border);
            border-top: 0;
            background: #1e293b;
            transition: all 0.2s;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            z-index: 10;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .custom-select.open .custom-options {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
            transform: translateY(2px);
        }

        .custom-option {
            position: relative;
            display: block;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-muted);
            line-height: 1.4;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .custom-option:last-of-type {
            border-bottom: 0;
        }

        .custom-option:hover,
        .custom-option.selected {
            color: var(--text-main);
            background: rgba(139, 92, 246, 0.1);
            padding-left: 1.25rem;
        }

        .custom-option.selected::after {
            content: '✓';
            position: absolute;
            right: 1rem;
            color: var(--primary);
        }

        /* Standard Select styled */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        pre {
            background: #000;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
            margin-top: 1rem;
            color: #a5b4fc;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Design System</h1>
            <p class="subtitle">Componentes e tokens para construção de interfaces modernas</p>
            <div style="margin-top: 2rem;">
                <a href="/" class="btn btn-secondary">← Voltar para Home</a>
            </div>
        </header>

        <!-- Botões -->
        <section class="card full-width">
            <h2>Botões</h2>
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div>
                    <h3 style="font-size: 1rem; color: var(--text-muted); margin-bottom: 1rem;">Variantes</h3>
                    <div class="btn-group">
                        <button class="btn btn-primary">Primary Action</button>
                        <button class="btn btn-secondary">Secondary</button>
                        <button class="btn btn-success">Success</button>
                        <button class="btn btn-danger">Danger</button>
                    </div>
                </div>
                <div>
                    <h3 style="font-size: 1rem; color: var(--text-muted); margin-bottom: 1rem;">Tamanhos</h3>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm">Small Button</button>
                        <button class="btn btn-primary">Default Button</button>
                        <button class="btn btn-primary btn-lg">Large Button</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="component-grid">
            <!-- Tipografia -->
            <section class="card">
                <h2>Tipografia</h2>
                <div class="typography-sample">
                    <h1>Heading 1</h1>
                    <h2>Heading 2</h2>
                    <h3>Heading 3</h3>
                    <p class="subtitle">Subtitle text example</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Small text for captions or helpers.</p>
                </div>
            </section>

            <!-- Alerts -->
            <section class="card">
                <h2>Alertas</h2>
                <div class="alert alert-info">
                    ℹ️ Nova atualização disponível.
                </div>
                <div class="alert alert-success">
                    ✅ Operação realizada com sucesso!
                </div>
                <div class="alert alert-warning">
                    ⚠️ Atenção: verifique seus dados.
                </div>
                <div class="alert alert-error">
                    ❌ Erro ao conectar com o servidor.
                </div>
            </section>

            <!-- Formulários -->
            <section class="card">
                <h2>Formulários</h2>
                <form>
                    <div class="form-group">
                        <label class="form-label" for="nome_completo">Nome Completo</label>
                        <input type="text" id="nome_completo" class="form-control" placeholder="Digite seu nome">
                    </div>

                    <!-- Native Select styled -->
                    <div class="form-group">
                        <label class="form-label">Categoria (Nativo Estilizado)</label>
                        <select class="form-control form-select">
                            <option>Selecione uma opção</option>
                            <option>Design</option>
                            <option>Desenvolvimento</option>
                            <option>Marketing</option>
                        </select>
                    </div>

                    <!-- Reusable Custom Select Component (PHP) -->
                    <?php
                    $label = 'Prioridade (Componente PHP)';
                    $name = 'prioridade';
                    $placeholder = 'Selecione o nível...';
                    $options = [
                        'low' => 'Baixa Prioridade',
                        'medium' => 'Média Prioridade',
                        'high' => 'Alta Prioridade',
                        'urgent' => 'Urgente 🚀'
                    ];
                    include __DIR__ . '/components/select.php';
                    ?>

                    <div style="height: 2rem;"></div>

                    <!-- Web Component JavaScript Example -->
                    <div class="form-group">
                        <custom-select label="Tecnologias (Web Component JS Puro)" name="tecnologias"
                            placeholder="Escolha a Tech Stack..."
                            options='[{"value":"js","label":"JavaScript"},{"value":"php","label":"PHP"},{"value":"python","label":"Python"},{"value":"go","label":"Golang"}]'></custom-select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="mensagem_usuario">Mensagem</label>
                        <textarea class="form-control" id="mensagem_usuario" rows="3"></textarea>
                    </div>
                </form>
            </section>
        </div>

        <!-- Script do Web Component -->
        <script src="/js/components/CustomSelect.js"></script>

        <!-- Badges e Status -->
        <section class="card">
            <h2>Badges & Tags</h2>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <span class="badge badge-primary">Novo</span>
                <span class="badge badge-success">Ativo</span>
                <span class="badge badge-warning">Pendente</span>
                <span class="badge" style="background: rgba(255,255,255,0.1);">Rascunho</span>
            </div>
            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1rem; margin-bottom: 1rem;">Cards Interativos</h3>
                <div style="padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 600;">Item da Lista</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Descrição curta</div>
                        </div>
                        <span class="badge badge-success">Concluído</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- HTML/CSS Playground Area suitable for the user -->
    <section class="card full-width">
        <h2>Área de Testes</h2>
        <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Use este espaço para testar seus próprios
            componentes HTML/CSS.</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div
                style="border: 1px dashed var(--border); padding: 2rem; border-radius: 8px; display: flex; align-items: center; justify-content: center; min-height: 200px;">
                <!-- Seus componentes aqui -->
                <div class="card" style="width: 100%; max-width: 300px; text-align: center;">
                    <div
                        style="width: 60px; height: 60px; background: var(--primary); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        🚀</div>
                    <h3>Card Exemplo</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem;">Um card simples
                        para começar.</p>
                    <button class="btn btn-secondary btn-sm" style="width: 100%;">Ação</button>
                </div>
            </div>

            <div style="background: #000; padding: 1.5rem; border-radius: 8px;">
                <pre><code style="color: #a5b4fc;">&lt;div class="card"&gt;
  &lt;div class="icon"&gt;🚀&lt;/div&gt;
  &lt;h3&gt;Card Exemplo&lt;/h3&gt;
  &lt;p&gt;Um card simples...&lt;/p&gt;
  &lt;button class="btn"&gt;Ação&lt;/button&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </section>

    </div>
</body>

</html>