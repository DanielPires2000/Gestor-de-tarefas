-- Criação da tabela de tarefas (PostgreSQL)
CREATE TABLE IF NOT EXISTS tarefas (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    status VARCHAR(20) DEFAULT 'pendente' CHECK (status IN ('pendente', 'concluida')),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados de exemplo (opcional)
INSERT INTO tarefas (titulo, descricao, status) VALUES 
('Tarefa de exemplo', 'Esta é uma tarefa de demonstração', 'pendente');
