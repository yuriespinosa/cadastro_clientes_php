-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 13-Jun-2021 às 23:49
-- Versão do servidor: 5.7.33
-- versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro_cliente`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` bigint(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `idade` int(11) NOT NULL,
  `endereco` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nome`, `idade`, `endereco`) VALUES
(1, 'Jorge', 255, 'Rua Frei Caneca,1420 X Av Palista, 1980/1992 1420'),
(2, 'Yuri Espinosa Pires', 255, 'Alameda Joaquim EugÃŠnio De Lim'),
(3, 'Luis', 255, 'Rua Frei Caneca,1420 X Av Palista, 1980/1992 1420'),
(4, 'Lucas', 255, 'Avenida 9 De Julho 5363'),
(5, 'Maisa', 255, 'Rua TabapuÃƒ 41'),
(6, 'Yago', 255, 'Rua Frei Caneca,1420 X Av Palista, 1980/1992 1420'),
(7, 'Luciano', 255, 'Alameda Joaquim EugÃŠnio De Lim'),
(8, 'Thiago', 255, 'Alameda Joaquim EugÃŠnio De Lim'),
(9, 'Jorge Pires', 255, 'Maria'),
(10, 'Jorge', 1, 'Alameda Joaquim EugÃŠnio De Lim'),
(12, 'Paulo', 16, 'Rua TabapuÃƒ 41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `login`, `senha`, `tipo`) VALUES
(1, 'adm', '1f591a4c440e29f36bc86358a832dcd1', 'Adm'),
(2, 'visitante', '34fd8e79cc3af8ceb849a52f08e66080', 'Adm'),
(3, 'visitante', '34fd8e79cc3af8ceb849a52f08e66080', 'Visitante'),
(4, 'adm2', '1f591a4c440e29f36bc86358a832dcd1', 'Adm');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
