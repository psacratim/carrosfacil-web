CREATE DATABASE carrosfacil_ti50
CHARSET=utf8 COLLATE=utf8_general_ci;

USE carrosfacil_ti50;

CREATE TABLE `marca` (
  `id` INT(9) PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(80) NOT NULL UNIQUE,
  `observacao` VARCHAR(250),
  `data_cadastro` DATE NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `modelo` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_marca` INT(9) NOT NULL,
  `nome` VARCHAR(80) NOT NULL UNIQUE,
  `observacao` VARCHAR(250),
  `data_cadastro` DATE NOT NULL,
  `status` BIT,

  FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`)
);

CREATE TABLE `cargo` (
  `id` INT(3) PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(60) UNIQUE NOT NULL,
  `observacao` VARCHAR(250),
  `data_cadastro` DATE NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `caracteristica` ( -- Ar condicionado, material do aro, cor do banco, etc...
  `id` INT(6) PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(80) UNIQUE NOT NULL,
  `observacao` VARCHAR(250) NOT NULL,
  `icone` VARCHAR(250) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `funcionario` (
  `id` INT(4) PRIMARY KEY AUTO_INCREMENT,
  `id_cargo` INT(3),
  `cpf` CHAR(14) UNIQUE NOT NULL,
  `rg` VARCHAR(12),
  `nome` VARCHAR(80) NOT NULL UNIQUE,
  `nome_social` VARCHAR(80),
  `senha` VARCHAR(255) NOT NULL,
  `salario` DECIMAL(10,2),
  `sexo` CHAR(1) NOT NULL,
  `usuario` VARCHAR(20) NOT NULL,
  `estado_civil` VARCHAR(20) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `tipo_acesso` INT(2) NOT NULL,
  `telefone_celular` CHAR(15),
  `telefone_recado` CHAR(15) NOT NULL,
  `telefone_residencial` CHAR(15),
  `endereco` VARCHAR(60) NOT NULL,
  `cep` CHAR(9),
  `numero` INT(5) NOT NULL,
  `complemento` VARCHAR(200),
  `bairro` VARCHAR(50) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `estado` VARCHAR(32) NOT NULL,
  `email` VARCHAR(120),
  `foto` VARCHAR(200),
  `data_cadastro` DATE NOT NULL,
  `status` BIT NOT NULL,

  FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`)
);

CREATE TABLE `cliente` (
  `id` INT(8) PRIMARY KEY AUTO_INCREMENT,
  `cpf` CHAR(14) UNIQUE NOT NULL,
  `rg` VARCHAR(12),
  `nome` VARCHAR(80) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `usuario` VARCHAR(20) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `endereco` VARCHAR(60) NOT NULL,
  `cep` CHAR(9),
  `numero` INT(5) NOT NULL,
  `complemento` VARCHAR(200),
  `bairro` VARCHAR(50) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `estado` VARCHAR(32) NOT NULL,
  `telefone1` CHAR(15) NOT NULL,
  `telefone2` CHAR(15),
  `email` VARCHAR(120),
  `estado_civil` VARCHAR(20) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `status` BIT
);

CREATE TABLE `veiculo` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_modelo` INT(11) NOT NULL,
  `categoria` VARCHAR(32) NOT NULL, -- SUVS, Esportivo
  `estado_do_veiculo` VARCHAR(26) NOT NULL, -- Usado | Novo
  `tempo_de_uso` INT(5) NOT NULL, -- Tempo de uso em dias: 1 dia, 365 dias, 1.265 dias, ... -> Limite: 99.999 dias (273 anos)
  `preco_custo` DECIMAL(12, 2) NOT NULL,
  `preco_venda` DECIMAL(12, 2) NOT NULL,
  `preco_desconto` DECIMAL(12, 2) NOT NULL,
  `desconto` INT(2) DEFAULT 0,
  `tem_desconto` BIT NOT NULL,
  `lucro` INT(5) NOT NULL,
  `quilometragem` INT(7) NOT NULL, -- Limite: 9.999.999 kms,
  -- `final_placa` VARCHAR(1) NOT NULL,
  `cor` VARCHAR(16) NOT NULL,
  `descricao` VARCHAR(250),
  `ano` INT(4) NOT NULL,
  `tipo_cambio` VARCHAR(48) NOT NULL,
  `tipo_combustivel` VARCHAR(48) NOT NULL,
  `foto` VARCHAR(250) NOT NULL,
  `estoque` INT(5) DEFAULT 0,
  `data_cadastro` DATE NOT NULL,
  `status` BIT,

  FOREIGN KEY (`id_modelo`) REFERENCES `modelo` (`id`)
);

CREATE TABLE `foto_veiculo` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_veiculo` INT(11) NOT NULL,
  `caminho` VARCHAR(250) NOT NULL,
  `ordem` INT(2) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `status` BIT,
  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`)
);

CREATE TABLE `caracteristica_carro` (
  `id_veiculo` INT(11) NOT NULL,
  `id_caracteristica` INT(6) NOT NULL,

  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`),
  FOREIGN KEY (`id_caracteristica`) REFERENCES `caracteristica` (`id`)
);

CREATE TABLE `venda` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_funcionario` INT(4) NOT NULL,
  `id_cliente` INT(8) NOT NULL,
  `valor_total` DECIMAL(12, 2) NOT NULL,
  `valor_desconto` DECIMAL(12, 2) NOT NULL,
  `desconto` INT(3) DEFAULT 0,
  `data_cadastro` DATETIME NOT NULL,
  `status` BIT,

  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id`),
  FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`)
);

CREATE TABLE `item_venda` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_veiculo` INT(11) NOT NULL,
  `id_venda` INT(11) NOT NULL,
  `quantidade` INT(3) NOT NULL,
  `valor_unitario` DECIMAL(12, 2) NOT NULL,
  `valor_total` DECIMAL(12, 2) NOT NULL,

  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`),
  FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`)
);

CREATE TABLE `pagamento_venda` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `id_venda` INT(11) NOT NULL,
  `metodo` VARCHAR(16) NOT NULL,
  `valor_final` DECIMAL(12, 2) NOT NULL,
  `parcelas` INT(2) NOT NULL,
  `status` BIT,

  FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`)
);