CREATE TABLE `marca` (
  `id` VARCHAR(10) PRIMARY KEY,
  `nome` VARCHAR(10),
  `data_cadastro` DATETIME NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `modelo` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_marca` VARCHAR(10),
  `nome` VARCHAR(10),
  `observacao` VARCHAR(10),
  `data_cadastro` VARCHAR(10),
  `status` VARCHAR(10),

  FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`)
);

CREATE TABLE `cargo` (
  `id` INT(3) PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(60) UNIQUE NOT NULL,
  `observacao` VARCHAR(250),
  `data_cadastro` DATETIME NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `acessorio` (
  `id` VARCHAR(10) PRIMARY KEY,
  `nome` VARCHAR(10),
  `descricao` VARCHAR(10),
  `observacao` VARCHAR(10),
  `icone` VARCHAR(10),
  `data_cadastro` DATETIME NOT NULL,
  `status` BIT NOT NULL
);

CREATE TABLE `funcionario` (
  `id` INT(4) PRIMARY KEY AUTO_INCREMENT,
  `id_cargo` INT(10),
  `cpf` CHAR(14) UNIQUE NOT NULL,
  `rg` VARCHAR(12) UNIQUE,
  `nome` VARCHAR(60) NOT NULL,
  `nome_social` VARCHAR(60),
  `senha` VARCHAR(26) NOT NULL,
  `salario` DECIMAL(10,2),
  `sexo` CHAR(1) NOT NULL,
  `usuario` VARCHAR(20) NOT NULL,
  `estado_civil` VARCHAR(20) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `tipo_acesso` VARCHAR(32) NOT NULL,
  `telefone_celular` CHAR(13),
  `telefone_recado` CHAR(13) NOT NULL,
  `telefone_residencial` CHAR(13),
  `endereco` VARCHAR(60) NOT NULL,
  `numero` INT(5) NOT NULL,
  `complemento` VARCHAR(200),
  `bairro` VARCHAR(32) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `estado` VARCHAR(32) NOT NULL,
  `email` VARCHAR(100),
  `cep` VARCHAR(10),
  `foto` VARCHAR(200),
  `data_cadastro` DATE NOT NULL,
  `status` BIT NOT NULL,

  FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`)
);

CREATE TABLE `cliente` (
  `id` VARCHAR(10) PRIMARY KEY,
  `cidade` VARCHAR(10),
  `estado` VARCHAR(10),
  `numero` VARCHAR(10),
  `endereco` VARCHAR(10),
  `complemento` VARCHAR(10),
  `bairro` VARCHAR(10),
  `cep` VARCHAR(10),
  `telefone1` VARCHAR(10),
  `email` VARCHAR(10),
  `data_nascimento` VARCHAR(10),
  `sexo` VARCHAR(10),
  `usuario` VARCHAR(10),
  `data_cadastro` VARCHAR(10),
  `status` VARCHAR(10),
  `rg` VARCHAR(10),
  `nome_completo` VARCHAR(10),
  `cpf` VARCHAR(10),
  `senha` VARCHAR(10),
  `telefone2` VARCHAR(10)
);

CREATE TABLE `veiculo` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_modelo` VARCHAR(10),
  `categoria` VARCHAR(10),
  `tempo_de_uso` VARCHAR(10),
  `tipo` VARCHAR(10),
  `preco` VARCHAR(10),
  `kms_rodado` VARCHAR(10),
  `numero_portas` VARCHAR(10),
  `placa` VARCHAR(10),
  `cor` VARCHAR(10),
  `descricao` VARCHAR(10),
  `ano` VARCHAR(10),
  `tipo_cambio` VARCHAR(10),
  `tipo_combustivel` VARCHAR(10),
  `estoque` VARCHAR(10),
  `data_cadastro` VARCHAR(10),
  `status` VARCHAR(10),
  `material_aro` VARCHAR(10),
  `material_assento` VARCHAR(10),

  FOREIGN KEY (`id_modelo`) REFERENCES `modelo` (`id`)
);

CREATE TABLE `foto_veiculo` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_veiculo` VARCHAR(10),
  `caminho` VARCHAR(10),
  `ordem` VARCHAR(10),
  `data_cadastro` VARCHAR(10),
  `status` VARCHAR(10),

  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`)
);

CREATE TABLE `acessorio_carro` (
  `id_veiculo` VARCHAR(10),
  `id_acessorio` VARCHAR(10),

  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`),
  FOREIGN KEY (`id_acessorio`) REFERENCES `acessorio` (`id`)
);

CREATE TABLE `venda` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_funcionario` INT(4),
  `id_cliente` VARCHAR(10),
  `data_cadastro` VARCHAR(10),
  `valor_total` VARCHAR(10),
  `data_venda` VARCHAR(10),
  `status` VARCHAR(10),

  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id`),
  FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`)
);

CREATE TABLE `item_venda` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_veiculo` VARCHAR(10),
  `id_venda` VARCHAR(10),
  `quantidade` VARCHAR(10),
  `valor_unitario` VARCHAR(10),

  FOREIGN KEY (`id_veiculo`) REFERENCES `veiculo` (`id`),
  FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`)
);

CREATE TABLE `pagamento` (
  `id` VARCHAR(10) PRIMARY KEY,
  `id_venda` VARCHAR(10),
  `tipo` VARCHAR(10),
  `valor` VARCHAR(10),
  `parcelas` VARCHAR(10),
  `desconto` VARCHAR(10),
  `status` VARCHAR(10),

  FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`)
);