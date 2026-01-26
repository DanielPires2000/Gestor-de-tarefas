class CustomSelect extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this._options = [];
        this._value = '';
    }

    static get observedAttributes() {
        return ['options', 'placeholder', 'label', 'name', 'value'];
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (oldValue === newValue) return;
        
        if (name === 'options') {
            try {
                this._options = JSON.parse(newValue);
                this.renderOptions();
            } catch (e) {
                console.error('Invalid JSON for options', e);
            }
        } else if (name === 'value') {
            this.selectValue(newValue);
        } else {
            this.render();
        }
    }

    connectedCallback() {
        this.render();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Toggle dropdown
        this.shadowRoot.querySelector('.trigger').addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggle();
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.contains(e.target)) {
                this.close();
            }
        });
    }

    toggle() {
        const container = this.shadowRoot.querySelector('.container');
        container.classList.toggle('open');
    }

    close() {
        const container = this.shadowRoot.querySelector('.container');
        if (container) container.classList.remove('open');
    }

    selectValue(value) {
        this._value = value;
        const option = this._options.find(o => o.value == value);
        
        // Update UI Text
        const textSpan = this.shadowRoot.querySelector('.trigger span');
        if (textSpan) {
            textSpan.textContent = option ? option.label : (this.getAttribute('placeholder') || 'Select...');
        }

        // Highlight selected option
        const optionsContainer = this.shadowRoot.querySelector('.options');
        if (optionsContainer) {
            Array.from(optionsContainer.children).forEach(el => {
                if (el.dataset.value == value) el.classList.add('selected');
                else el.classList.remove('selected');
            });
        }

        // Update Hidden Input (in Light DOM for form submission)
        let hiddenInput = this.querySelector('input[type="hidden"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = this.getAttribute('name') || 'custom-select';
            this.appendChild(hiddenInput);
        }
        hiddenInput.value = value;

        // Dispatch Change Event
        this.dispatchEvent(new CustomEvent('change', { detail: { value } }));
        
        // Close dropdown
        this.close();
    }

    renderOptions() {
        const optionsContainer = this.shadowRoot.querySelector('.options');
        if (!optionsContainer) return;

        optionsContainer.innerHTML = '';
        this._options.forEach(opt => {
            const el = document.createElement('div');
            el.className = 'option';
            if (opt.value == this._value) el.classList.add('selected');
            el.dataset.value = opt.value;
            el.textContent = opt.label;
            
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                this.selectValue(opt.value);
            });
            
            optionsContainer.appendChild(el);
        });
    }

    render() {
        const label = this.getAttribute('label');
        const placeholder = this.getAttribute('placeholder') || 'Select Option';

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    display: block;
                    width: 100%;
                    font-family: 'Inter', sans-serif;
                    margin-bottom: 1rem;
                    text-align: left;
                }
                
                * { box-sizing: border-box; }

                .label {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-size: 0.9rem;
                    color: #94a3b8; /* text-muted */
                }

                .container {
                    position: relative;
                }

                .trigger {
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0.75rem 1rem;
                    font-size: 0.95rem;
                    font-weight: 500;
                    color: #f1f5f9; /* text-main */
                    background: rgba(0, 0, 0, 0.2);
                    border: 1px solid rgba(148, 163, 184, 0.1);
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.2s;
                }

                .trigger:hover {
                    background: rgba(255, 255, 255, 0.05);
                    border-color: rgba(148, 163, 184, 0.3);
                }

                .container.open .trigger {
                    border-color: #8b5cf6; /* primary */
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                }

                .arrow {
                    position: relative;
                    height: 10px;
                    width: 10px;
                }

                .arrow::before, .arrow::after {
                    content: "";
                    position: absolute;
                    bottom: 0px;
                    width: 0.15rem;
                    height: 100%;
                    transition: all 0.2s;
                    background-color: #94a3b8;
                }

                .arrow::before { left: -3px; transform: rotate(-45deg); }
                .arrow::after { left: 3px; transform: rotate(45deg); }

                .container.open .arrow::before { left: -3px; transform: rotate(45deg); }
                .container.open .arrow::after { left: 3px; transform: rotate(-45deg); }

                .options {
                    position: absolute;
                    top: 100%;
                    left: 0;
                    right: 0;
                    background: #1e293b;
                    border: 1px solid rgba(148, 163, 184, 0.1);
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                    z-index: 100;
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(-10px);
                    transition: all 0.2s;
                    max-height: 200px;
                    overflow-y: auto;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                }

                .container.open .options {
                    opacity: 1;
                    visibility: visible;
                    transform: translateY(0);
                }

                .option {
                    padding: 0.75rem 1rem;
                    cursor: pointer;
                    color: #94a3b8;
                    transition: all 0.2s;
                }

                .option:hover, .option.selected {
                    background: rgba(139, 92, 246, 0.1);
                    color: white;
                    padding-left: 1.25rem;
                }
                
                .option.selected::after {
                    content: '✓';
                    float: right;
                    color: #8b5cf6;
                }
            </style>

            <div>
                ${label ? `<span class="label">${label}</span>` : ''}
                <div class="container">
                    <div class="trigger">
                        <span>${placeholder}</span>
                        <div class="arrow"></div>
                    </div>
                    <div class="options"></div>
                </div>
            </div>
        `;
        
        this.renderOptions();
    }
}

customElements.define('custom-select', CustomSelect);
