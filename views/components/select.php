<?php
/**
 * Componente Select Customizado
 * 
 * @var string $label Título do select
 * @var array $options Array de opções ['value' => 'Label'] ou [['value' => 'v', 'label' => 'l']]
 * @var string $placeholder Texto de placeholder
 * @var string $name Nome do input hidden (para formulários)
 */

// Garantir ID único para este componente se não for passado
$componentId = $id ?? 'select-' . uniqid();
$placeholder = $placeholder ?? 'Selecione uma opção';
$name = $name ?? 'custom-select';

// 1. CSS (Renderizado apenas uma vez por página)
global $customSelectStylesRendered;
if (!isset($customSelectStylesRendered)):
    $customSelectStylesRendered = true;
    ?>
    <style>
        .custom-select-wrapper {
            position: relative;
            user-select: none;
            width: 100%;
            margin-bottom: 1rem;
        }

        .custom-select-container {
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
            color: var(--text-main, #f1f5f9);
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border, rgba(255, 255, 255, 0.1));
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-select-trigger:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(148, 163, 184, 0.3);
        }

        .custom-select-container.open .custom-select-trigger {
            border-color: var(--primary, #8b5cf6);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .custom-select-arrow {
            position: relative;
            height: 10px;
            width: 10px;
        }

        .custom-select-arrow::before,
        .custom-select-arrow::after {
            content: "";
            position: absolute;
            bottom: 0px;
            width: 0.15rem;
            height: 100%;
            transition: all 0.2s;
            background-color: var(--text-muted, #94a3b8);
        }

        .custom-select-arrow::before {
            left: -3px;
            transform: rotate(-45deg);
        }

        .custom-select-arrow::after {
            left: 3px;
            transform: rotate(45deg);
        }

        .custom-select-container.open .custom-select-arrow::before {
            left: -3px;
            transform: rotate(45deg);
        }

        .custom-select-container.open .custom-select-arrow::after {
            left: 3px;
            transform: rotate(-45deg);
        }

        .custom-options {
            position: absolute;
            display: block;
            top: 100%;
            left: 0;
            right: 0;
            border: 1px solid var(--border, rgba(255, 255, 255, 0.1));
            border-top: 0;
            background: #1e293b;
            transition: all 0.2s;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            z-index: 50;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-height: 200px;
            overflow-y: auto;
        }

        .custom-select-container.open .custom-options {
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
            color: var(--text-muted, #94a3b8);
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .custom-option:hover,
        .custom-option.selected {
            color: var(--text-main, #fff);
            background: rgba(139, 92, 246, 0.1);
            padding-left: 1.25rem;
        }

        .custom-option.selected::after {
            content: '✓';
            position: absolute;
            right: 1rem;
            color: var(--primary, #8b5cf6);
        }
    </style>
<?php endif; ?>

<!-- 2. Estrutura HTML do Componente -->
<div class="custom-select-wrapper" id="<?= $componentId ?>">
    <?php if (!empty($label)): ?>
        <label class="form-label">
            <?= $label ?>
        </label>
    <?php endif; ?>

    <div class="custom-select-container">
        <div class="custom-select-trigger" onclick="toggleSelect('<?= $componentId ?>')">
            <span class="trigger-text">
                <?= $placeholder ?>
            </span>
            <div class="custom-select-arrow"></div>
        </div>

        <div class="custom-options">
            <?php foreach ($options as $optValue => $optLabel): ?>
                <?php
                // Suporte para array simples ou associativo
                $val = is_array($optLabel) ? $optLabel['value'] : $optValue;
                $txt = is_array($optLabel) ? $optLabel['label'] : $optLabel;
                ?>
                <span class="custom-option" data-value="<?= htmlspecialchars($val) ?>"
                    onclick="selectOption('<?= $componentId ?>', this, '<?= htmlspecialchars($val) ?>')">
                    <?= htmlspecialchars($txt) ?>
                </span>
            <?php endforeach; ?>
        </div>

        <!-- Input real oculto para envio de formulário -->
        <input type="hidden" name="<?= $name ?>" class="select-hidden-input">
    </div>
</div>

<!-- 3. JS Global (Renderizado apenas uma vez) -->
<?php
global $customSelectScriptRendered;
if (!isset($customSelectScriptRendered)):
    $customSelectScriptRendered = true;
    ?>
    <script>
        // Função global para alternar visibilidade
        function toggleSelect(id) {
            const wrapper = document.getElementById(id);
            const container = wrapper.querySelector('.custom-select-container');

            // Fecha outros selects abertos
            document.querySelectorAll('.custom-select-container.open').forEach(el => {
                if (el !== container) el.classList.remove('open');
            });

            container.classList.toggle('open');
        }

        // Função global para selecionar opção
        function selectOption(id, optionElement, value) {
            const wrapper = document.getElementById(id);
            const container = wrapper.querySelector('.custom-select-container');
            const triggerText = wrapper.querySelector('.trigger-text');
            const hiddenInput = wrapper.querySelector('.select-hidden-input');

            // Atualiza visual
            container.classList.remove('open');
            container.querySelectorAll('.custom-option').forEach(opt => opt.classList.remove('selected'));
            optionElement.classList.add('selected');

            // Atualiza valores
            triggerText.textContent = optionElement.textContent.trim();
            hiddenInput.value = value;

            // Opcional: Disparar evento de change manual se necessário
            const event = new Event('change');
            hiddenInput.dispatchEvent(event);
        }

        // Fechar ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.custom-select-container')) {
                document.querySelectorAll('.custom-select-container.open').forEach(el => {
                    el.classList.remove('open');
                });
            }
        });
    </script>
<?php endif; ?>