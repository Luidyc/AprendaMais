create database aprendendomaisphp;
use aprendendomaisphp;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aprendendomaisphp3`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `matricula` varchar(20) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`matricula`, `nome`, `telefone`, `email`) VALUES
('MAT001','Maria Silva','71 91234-5678','maria.silva@gmail.com'),
('MAT002', 'João Santos', '71 98765-4321', 'joao.santos@gmail.com'),
('MAT003', 'Ana Ferreira', '71 97654-3210', 'ana.ferreira@gmail.com'),
('MAT004', 'Pedro Oliveira', '71 94321-8765', 'pedro.oliveira@gmail.com'),
('MAT005', 'Camila Souza', '71 91234-5678', 'camila.souza@gmail.com'),
('MAT006', 'Luiz Pereira', '71 98765-4321', 'luiz.pereira@gmail.com'),
('MAT007', 'Beatriz Alves', '71 97654-3210', 'beatriz.alves@gmail.com'),
('MAT008', 'Gabriel Lima', '71 94321-8765', 'gabriel.lima@gmail.com'),
('MAT009', 'Laura Ribeiro', '71 91234-5678', 'laura.ribeiro@gmail.com'),
('MAT010', 'Lucas Gomes', '71 98765-4321', 'lucas.gomes@gmail.com'),
('MAT011', 'Sofia Barbosa', '71 97654-3210', 'sofia.barbosa@gmail.com'),
('MAT012', 'Enzo Rodrigues', '71 94321-8765', 'enzo.rodrigues@gmail.com'),
('MAT013', 'Isabela Santos', '71 91234-5678', 'isabela.santos@gmail.com'),
('MAT014', 'Arthur Martins', '71 98765-4321', 'arthur.martins@gmail.com'),
('MAT015', 'Alice Pereira', '71 97654-3210', 'alice.pereira@gmail.com'),
('MAT016', 'Bernardo Almeida', '71 94321-8765', 'bernardo.almeida@gmail.com'),
('MAT017', 'Valentina Lima', '71 91234-5678', 'valentina.lima@gmail.com'),
('MAT018', 'Theo Castro', '71 98765-4321', 'theo.castro@gmail.com'),
('MAT019', 'Helena Ferreira', '71 97654-3210', 'helena.ferreira@gmail.com'),
('MAT020', 'Samuel Oliveira', '71 94321-8765', 'samuel.oliveira@gmail.com'),
('MAT021', 'Lívia Almeida', '71 91234-5678', 'livia.almeida@gmail.com'),
('MAT022', 'Davi Ribeiro', '71 98765-4321', 'davi.ribeiro@gmail.com'),
('MAT023', 'Isabella Gomes', '71 97654-3210', 'isabella.gomes@gmail.com'),
('MAT024', 'Matheus Rodrigues', '71 94321-8765', 'matheus.rodrigues@gmail.com'),
('MAT025', 'Mariana Santos', '71 91234-5678', 'mariana.santos@gmail.com'),
('MAT026', 'Gabriel Barbosa', '71 98765-4321', 'gabriel.barbosa@gmail.com'),
('MAT027', 'Eloá Martins', '71 97654-3210', 'eloa.martins@gmail.com'),
('MAT028', 'Arthur Almeida', '71 94321-8765', 'arthur.almeida@gmail.com'),
('MAT029', 'Sophia Lima', '71 91234-5678', 'sophia.lima@gmail.com'),
('MAT030', 'Gustavo Castro', '71 98765-4321', 'gustavo.castro@gmail.com'),
('MAT031', 'Maria Eduarda Oliveira', '71 97654-3210', 'mariaeduarda.oliveira@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `idcurso` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `idinstituicao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`idcurso`, `nome`, `idinstituicao`) VALUES
(3, 'Desenvolvimento de Sistemas', 1),
(4, 'Técnico em Mecatrônica', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `desempenho_aluno_turma`
--

CREATE TABLE `desempenho_aluno_turma` (
  `matricula` varchar(20) NOT NULL,
  `idturma` int(11) NOT NULL,
  `nota` decimal(4,2) DEFAULT NULL,
  `falta` int(11) DEFAULT NULL,
  `previsoes` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `desempenho_aluno_turma`
--

INSERT INTO `desempenho_aluno_turma` (`matricula`, `idturma`, `nota`, `falta`, `previsoes`) VALUES
('MAT004', 6, '6.50', 9, NULL),
('MAT005', 6, '9.50', 12, NULL),
('MAT006', 6, '8.70', 12, NULL),
('MAT007', 6, '0.00', 36, NULL),
('MAT008', 6, '3.20', 19, NULL),
('MAT009', 6, '6.30', 0, NULL),
('MAT010', 6, '9.70', 0, NULL),
('MAT011', 6, '7.50', 3, NULL),
('MAT012', 6, '8.80', 6, NULL),
('MAT013', 6, '8.70', 3, NULL),
('MAT014', 6, '6.00', 18, NULL),
('MAT015', 6, '0.00', 66, NULL),
('MAT016', 6, '6.20', 12, NULL),
('MAT017', 6, '9.30', 3, NULL),
('MAT018', 6, '0.00', 66, NULL),
('MAT019', 6, '8.70', 0, NULL),
('MAT020', 6, '6.50', 18, NULL),
('MAT021', 6, '10.00', 3, NULL),
('MAT022', 6, '5.50', 9, NULL),
('MAT023', 6, '6.00', 12, NULL),
('MAT024', 6, '6.80', 12, NULL),
('MAT025', 6, '9.30', 9, NULL),
('MAT026', 6, '9.30', 0, NULL),
('MAT027', 6, '0.00', 66, NULL),
('MAT028', 6, '6.50', 15, NULL),
('MAT029', 6, '8.00', 10, NULL),
('MAT030', 6, '8.70', 6, NULL),
('MAT031', 6, '8.30', 12, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `iddisciplina` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `idcurso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`iddisciplina`, `nome`, `idcurso`) VALUES
(2, 'Modelagem de Sistemas', 3),
(3, 'Lógica de Programação', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao`
--

CREATE TABLE `instituicao` (
  `idinstituicao` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `instituicao`
--

INSERT INTO `instituicao` (`idinstituicao`, `nome`, `cnpj`, `telefone`, `email`) VALUES
(1, 'SENAI CAMAÇARI', '00045695781377', '71 93648-1900', 'Senaicamacari@ba.intituicao.org');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `idprofessor` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`idprofessor`, `nome`, `email`) VALUES
(2, 'Izadora Bispo', 'Izadora.Bispo@docente.senai.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `idturma` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `idprofessor` int(11) NOT NULL,
  `iddisciplina` int(11) NOT NULL,
  `tipodeturma` char(1) NOT NULL,
  `data_registro` datetime NOT NULL,
  `percentualregresso` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`idturma`, `nome`, `idprofessor`, `iddisciplina`, `tipodeturma`, `data_registro`, `percentualregresso`) VALUES
(6, 'DS2022.2-CMC.NOT', 2, 3, 'F', '2023-11-28 00:11:50', -0.89),
(8, 'DS2023.2-CMC.NOT', 2, 3, 'A', '2023-11-28 00:24:24', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`matricula`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idcurso`),
  ADD KEY `idinstituicao` (`idinstituicao`);

--
-- Índices para tabela `desempenho_aluno_turma`
--
ALTER TABLE `desempenho_aluno_turma`
  ADD PRIMARY KEY (`matricula`,`idturma`),
  ADD KEY `idturma` (`idturma`);

--
-- Índices para tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`iddisciplina`),
  ADD KEY `idcurso` (`idcurso`);

--
-- Índices para tabela `instituicao`
--
ALTER TABLE `instituicao`
  ADD PRIMARY KEY (`idinstituicao`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`idprofessor`);

--
-- Índices para tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`idturma`),
  ADD KEY `idprofessor` (`idprofessor`),
  ADD KEY `iddisciplina` (`iddisciplina`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `idcurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `iddisciplina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `instituicao`
--
ALTER TABLE `instituicao`
  MODIFY `idinstituicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idprofessor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `idturma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idinstituicao`) REFERENCES `instituicao` (`idinstituicao`);

--
-- Limitadores para a tabela `desempenho_aluno_turma`
--
ALTER TABLE `desempenho_aluno_turma`
  ADD CONSTRAINT `desempenho_aluno_turma_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE,
  ADD CONSTRAINT `desempenho_aluno_turma_ibfk_2` FOREIGN KEY (`idturma`) REFERENCES `turma` (`idturma`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `disciplina_ibfk_1` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`idprofessor`) REFERENCES `professor` (`idprofessor`),
  ADD CONSTRAINT `turma_ibfk_2` FOREIGN KEY (`iddisciplina`) REFERENCES `disciplina` (`iddisciplina`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
