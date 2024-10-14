-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/10/2024 às 14:11
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `digital_print`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `codAgend` int(5) NOT NULL,
  `cod_func` varchar(50) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `dataRegistro` date NOT NULL,
  `dataPrazo` date NOT NULL,
  `informacao` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`codAgend`, `cod_func`, `titulo`, `dataRegistro`, `dataPrazo`, `informacao`) VALUES
(23, 'Samuel de Jesus', 'Finalizar o TCC', '2024-10-10', '2024-11-10', 'Bora acabar o TCC filhão, tu ta solando o sistema e ainda ta atrasado!?');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `codCat` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`codCat`, `nome`) VALUES
(4, 'Banner'),
(5, 'Cartão de visita'),
(6, 'Fachada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dp_login`
--

CREATE TABLE `dp_login` (
  `log_id` int(5) NOT NULL,
  `log_email` varchar(50) NOT NULL,
  `log_senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dp_login`
--

INSERT INTO `dp_login` (`log_id`, `log_email`, `log_senha`) VALUES
(1, 'teste', 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `cod_func` int(5) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`cod_func`, `nome`) VALUES
(2, 'Jenifer Soares'),
(3, 'Samuel de Jesus'),
(4, 'Matheus Coelho'),
(5, 'Gabriel Roma'),
(6, 'Gabrielle Regina'),
(7, 'Davi Nicésio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `cod_itensPed` int(5) NOT NULL,
  `codPed` int(5) NOT NULL,
  `codPro` varchar(5) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `quantidade` int(5) NOT NULL,
  `valorUnit` decimal(10,0) NOT NULL,
  `valorTotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`cod_itensPed`, `codPed`, `codPro`, `medida`, `quantidade`, `valorUnit`, `valorTotal`) VALUES
(10, 10, 'Banne', '50x50', 4, 45, 180);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `codPed` int(5) NOT NULL,
  `cod_func` varchar(50) NOT NULL,
  `tipoPessoa` varchar(50) NOT NULL,
  `nomeCli` varchar(50) NOT NULL,
  `contato` varchar(50) NOT NULL,
  `descr` text NOT NULL,
  `dataPed` date NOT NULL,
  `dataPrev` date NOT NULL,
  `entrega` varchar(50) NOT NULL,
  `logradouro` varchar(50) NOT NULL,
  `numero` int(5) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `entrada` varchar(50) NOT NULL,
  `formaPag` varchar(30) NOT NULL,
  `valorEnt` decimal(10,0) NOT NULL,
  `valorTotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`codPed`, `cod_func`, `tipoPessoa`, `nomeCli`, `contato`, `descr`, `dataPed`, `dataPrev`, `entrega`, `logradouro`, `numero`, `bairro`, `entrada`, `formaPag`, `valorEnt`, `valorTotal`) VALUES
(10, 'Matheus Coelho', 'Física', 'samuel', '13213213', 'gghgfjh', '2024-10-14', '2024-10-29', 'entrega', 'jaja', 82, 'terere', 'sim', 'cartaoCredito', 50, 180);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `codPro` int(5) NOT NULL,
  `codCat` varchar(50) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `valor` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`codPro`, `codCat`, `medida`, `valor`) VALUES
(4, 'Banner', '50x50', 45),
(5, 'Cartão de visita', '9x5', 124),
(6, 'Fachada', '50x50', 46),
(9, 'Banner', '75x75', 12313);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`codAgend`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codCat`);

--
-- Índices de tabela `dp_login`
--
ALTER TABLE `dp_login`
  ADD PRIMARY KEY (`log_id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`cod_func`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`cod_itensPed`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codPed`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codPro`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `codAgend` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codCat` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `dp_login`
--
ALTER TABLE `dp_login`
  MODIFY `log_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `cod_func` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `cod_itensPed` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `codPed` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codPro` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
