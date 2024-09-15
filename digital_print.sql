-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/09/2024 às 21:04
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
(12, 'jenifer', 'Jenifer', '2024-09-15', '2024-09-18', 'ppppppp'),
(13, 'jenifer', 'sla2', '2024-09-15', '2024-09-22', 'ooooooooo'),
(15, 'jenifer', 'lavar louça', '2024-09-15', '2024-09-15', 'llllllllllllllll');

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
(5, 'Cartão de visita');

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
(1, 'jenifer');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `cod_itensPed` int(5) NOT NULL,
  `codPro` int(5) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `quantidade` int(5) NOT NULL,
  `valorUnit` decimal(10,0) NOT NULL,
  `valorTotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `valorEnt` decimal(10,0) NOT NULL,
  `valorTotal` decimal(10,0) NOT NULL,
  `cod_itensPed` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 'Cartão de visita', '9x5', 124);

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
  MODIFY `codAgend` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codCat` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `dp_login`
--
ALTER TABLE `dp_login`
  MODIFY `log_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `cod_func` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `cod_itensPed` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `codPed` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codPro` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
