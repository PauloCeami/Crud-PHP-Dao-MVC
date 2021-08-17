-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Ago-2021 às 19:36
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ist`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `id` int(11) NOT NULL,
  `numero_conta` bigint(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`id`, `numero_conta`, `pessoa_id`) VALUES
(24, 1111111111, 11),
(25, 2222222222, 12),
(27, 3333333333, 13),
(30, 5555555555, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `conta_id` int(11) NOT NULL,
  `tipo_movimento` varchar(20) NOT NULL,
  `data_hora` datetime NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `movimentacao`
--

INSERT INTO `movimentacao` (`id`, `pessoa_id`, `conta_id`, `tipo_movimento`, `data_hora`, `valor`) VALUES
(1, 11, 24, 'RETIRAR', '2021-07-31 07:45:49', '-100.00'),
(2, 11, 24, 'RETIRAR', '2021-07-25 08:52:40', '-200.00'),
(3, 11, 24, 'DEPOSITAR', '2021-07-25 08:52:40', '500.00'),
(9, 11, 24, 'RETIRAR', '2021-07-31 06:54:37', '-200.00'),
(12, 11, 24, 'DEPOSITAR', '2021-07-31 06:56:30', '1000.00'),
(13, 11, 24, 'RETIRAR', '2021-07-31 06:56:47', '-200.00'),
(14, 12, 25, 'DEPOSITAR', '2021-07-31 07:52:21', '250.00'),
(15, 11, 24, 'RETIRAR', '2021-07-31 09:04:19', '-800.00'),
(16, 11, 24, 'DEPOSITAR', '2021-07-31 09:11:52', '300.00'),
(17, 12, 25, 'RETIRAR', '2021-07-31 09:13:40', '-250.00'),
(18, 17, 30, 'DEPOSITAR', '2021-07-31 09:31:08', '96582.22'),
(19, 11, 24, 'RETIRAR', '2021-07-31 10:21:21', '-150.00'),
(21, 11, 24, 'DEPOSITAR', '2021-07-31 10:26:53', '433.33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` char(11) NOT NULL,
  `endereco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `cpf`, `endereco`) VALUES
(11, 'Paulo Roberto Dos Santos', '22124254812', 'rua dos programadores 160'),
(12, 'Gisele Cristina Do Nascimento', '56465498789', 'rua das salgadeiras 1000'),
(13, 'Rodrigo De Souza', '11122233344', 'endere??o do rodrigo'),
(16, 'Pedro Paulo Dos Snt', '23123213212', 'rua maria do carmo 160'),
(17, 'Maria Do Carmo', '65456798789', 'rua das espingardas php 1000');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pessoa` (`pessoa_id`);

--
-- Índices para tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conta` (`conta_id`);

--
-- Índices para tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `conta`
--
ALTER TABLE `conta`
  ADD CONSTRAINT `fk_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`);

--
-- Limitadores para a tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `fk_conta` FOREIGN KEY (`conta_id`) REFERENCES `conta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
