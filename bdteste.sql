-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2016 às 16:51
-- Versão do servidor: 10.1.13-MariaDB
-- Versão do PHP: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdteste`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabelatestando`
--

CREATE TABLE `tabelatestando` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL DEFAULT 'NOT NULL',
  `sexo` enum('Masculino','Feminino') NOT NULL,
  `datadenascimento` date NOT NULL,
  `dataehoraregistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `tabelatestando`
--

INSERT INTO `tabelatestando` (`id`, `nome`, `sexo`, `datadenascimento`, `dataehoraregistro`) VALUES
(1, '', 'Feminino', '2016-08-25', '2016-08-25 14:51:00');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tabelatestando`
--
ALTER TABLE `tabelatestando`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tabelatestando`
--
ALTER TABLE `tabelatestando`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
