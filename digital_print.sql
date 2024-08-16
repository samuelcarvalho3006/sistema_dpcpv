-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/08/2024 às 02:36
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
-- Estrutura para tabela `cadastros_pedidos`
--

CREATE TABLE `cadastros_pedidos` (
  `Cod_Pedidos` int(5) NOT NULL,
  `Pessoa` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Contato` varchar(50) NOT NULL,
  `Cod_produto` varchar(50) NOT NULL,
  `Quantidade` int(5) NOT NULL,
  `Descricao` text NOT NULL,
  `Med_Personalizada` varchar(50) NOT NULL,
  `Valor` decimal(10,0) NOT NULL,
  `Data_Prevista` date NOT NULL,
  `Status_Pag` varchar(50) NOT NULL,
  `Valor_Total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastros_produtos`
--

CREATE TABLE `cadastros_produtos` (
  `Cod_produto` int(5) NOT NULL,
  `Pro_nome` varchar(50) NOT NULL,
  `Medida` varchar(50) NOT NULL,
  `Descricao` text NOT NULL,
  `Valor` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastros_pedidos`
--
ALTER TABLE `cadastros_pedidos`
  ADD PRIMARY KEY (`Cod_Pedidos`);

--
-- Índices de tabela `cadastros_produtos`
--
ALTER TABLE `cadastros_produtos`
  ADD PRIMARY KEY (`Cod_produto`);

--
-- Índices de tabela `dp_login`
--
ALTER TABLE `dp_login`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastros_pedidos`
--
ALTER TABLE `cadastros_pedidos`
  MODIFY `Cod_Pedidos` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cadastros_produtos`
--
ALTER TABLE `cadastros_produtos`
  MODIFY `Cod_produto` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dp_login`
--
ALTER TABLE `dp_login`
  MODIFY `log_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
