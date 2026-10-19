CREATE TABLE IF NOT EXISTS usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    e_mail VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS carros (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(255) NOT NULL,
    modelo VARCHAR(255) NOT NULL,
    versao VARCHAR(255) NOT NULL,
    ano INT NOT NULL,
    preco DECIMAL(12, 2) NOT NULL,
    quilometragem INT NOT NULL,
    cor VARCHAR(50) NOT NULL,
    combustivel VARCHAR(50) NOT NULL,
    cambio VARCHAR(50) NOT NULL,
    numero_portas INT NOT NULL,
    descricao TEXT NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    quantidade_disponivel INT NOT NULL DEFAULT 1,
    status VARCHAR(50) NOT NULL DEFAULT 'disponivel',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS carrinho (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT UNSIGNED NOT NULL,
    carro_id BIGINT UNSIGNED NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_carrinho_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    CONSTRAINT fk_carrinho_carro FOREIGN KEY (carro_id) REFERENCES carros(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO carros (marca, modelo, versao, ano, preco, quilometragem, cor, combustivel, cambio, numero_portas, descricao, imagem, quantidade_disponivel, status, created_at, updated_at) VALUES
('Toyota', 'Corolla', 'Altis 2.0 Flex', 2023, 145000.00, 25000, 'Branco', 'Flex', 'Automático', 4, 'Sedan completo com assistentes avançados de condução, piloto automático adaptativo e bancos em couro.', 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=800', 3, 'disponivel', NOW(), NOW()),
('Honda', 'Civic', 'Touring 1.5 Turbo', 2022, 160000.00, 32000, 'Preto', 'Gasolina', 'Automático', 4, 'Sedã sofisticado com teto solar elétrico, bancos em couro, faróis full LED e sistema de som premium.', 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800', 2, 'disponivel', NOW(), NOW()),
('Volkswagen', 'Golf', 'GTI 2.0 TSI', 2021, 195000.00, 41000, 'Vermelho', 'Gasolina', 'Automático DSG', 4, 'Hatch esportivo de alta performance com motor turbo de 230cv, painel digital Active Info Display e modos de condução.', 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=800', 1, 'disponivel', NOW(), NOW()),
('Chevrolet', 'Onix', 'Premier 1.0 Turbo', 2024, 98000.00, 12000, 'Prata', 'Flex', 'Automático', 4, 'Hatch compacto e econômico com Wi-Fi nativo, carregador por indução, 6 airbags e alerta de ponto cego.', 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800', 5, 'disponivel', NOW(), NOW()),
('Jeep', 'Compass', 'Limited 1.3 Turbo', 2023, 178000.00, 28000, 'Cinza', 'Flex', 'Automático', 4, 'SUV médio com acabamento refinado, painel digital de 10.25 polegadas, teto panorâmico e porta-malas elétrico.', 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800', 2, 'disponivel', NOW(), NOW()),
('Ford', 'Ranger', 'XLT 3.2 4x4', 2022, 215000.00, 55000, 'Azul', 'Diesel', 'Automático', 4, 'Picape robusta com tração 4x4 e reduzida, diferencial blocante, protetor de caçamba e alta capacidade off-road.', 'https://images.unsplash.com/photo-1551830820-330a71b99659?w=800', 2, 'disponivel', NOW(), NOW()),
('Hyundai', 'HB20', 'Platinum Plus 1.0 Turbo', 2023, 92000.00, 18000, 'Branco', 'Flex', 'Automático', 4, 'Hatch moderno equipado com frenagem autônoma de emergência, assistente de permanência em faixa e central BlueMedia.', 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800', 4, 'disponivel', NOW(), NOW()),
('BMW', '320i', 'M Sport 2.0 Turbo', 2023, 310000.00, 15000, 'Azul Marinho', 'Flex', 'Automático', 4, 'Sedã esportivo premium com tração traseira, kit aerodinâmico M Sport, faróis BMW Laserlight e sistema Harman Kardon.', 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800', 1, 'disponivel', NOW(), NOW());

INSERT INTO usuarios (nome, cpf, data_nascimento, e_mail, telefone, endereco, numero, cidade, estado, senha, created_at, updated_at) VALUES
('Carlos Eduardo Silva', '123.456.789-00', '1995-05-15', 'carlos@turcar.com', '(11) 98765-4321', 'Avenida Paulista', '1000', 'São Paulo', 'SP', '$2y$12$eIn0.gH9j1sFviM3iBkn/uWskD/e7zG2wL0dYyFqU0pMhU5Z2w5e.', NOW(), NOW());
