create database aprendendoMaisPhp;
use aprendendoMaisPhp;
SET SQL_SAFE_UPDATES=0;


-- Tabela para armazenar informações sobre as instituições
CREATE TABLE instituicao (
    idinstituicao INT PRIMARY KEY auto_increment,
    nome VARCHAR(255),
    cnpj VARCHAR(14),
    telefone varchar(45),
    email varchar(45)
);

insert into instituicao (nome,cnpj,telefone, email) values ('SENAI CAMAÇARI',00045695781377,'71 93648-1900','Senaicamacari@ba.intituicao.org');

-- Tabela para armazenar informações sobre os cursos
CREATE TABLE curso (
    idcurso INT PRIMARY KEY auto_increment,
    nome VARCHAR(45),
    idinstituicao INT,
    FOREIGN KEY (idinstituicao) REFERENCES instituicao(idinstituicao)
);
insert into curso(nome,idinstituicao) values ('Desenvolvimento de Sistemas',1);
select * from disciplina;
-- Tabela para armazenar informações sobre as disciplinas
CREATE TABLE disciplina (
    iddisciplina INT PRIMARY KEY auto_increment,
    nome VARCHAR(45),
    idcurso INT,
    FOREIGN KEY (idcurso) REFERENCES curso(idcurso)
);

insert into disciplina(nome,idcurso) values ('Lógica de Programação',1);
-- Tabela para armazenar informações sobre os professores
CREATE TABLE professor (
    idprofessor INT PRIMARY KEY auto_increment,
    nome VARCHAR(255),
    email varchar(45)
);

insert into professor(nome,email) values ('Izadora B','Izadora.b@ba.docente.senai.br');

-- Tabela para armazenar informações sobre as turmas
CREATE TABLE turma (
    idturma INT PRIMARY KEY auto_increment,
    nome VARCHAR(255),
    idprofessor INT,
    FOREIGN KEY (idprofessor) REFERENCES professor(idprofessor),
    iddisciplina int,
    foreign key (iddisciplina) references disciplina(iddisciplina),
    tipodeturma char(1),
    -- A = Em andamento / F = Finalizada;
    data_registro datetime,
    percentualregresso float(4)
);


-- Tabela para armazenar informações sobre os alunos
CREATE TABLE aluno (
    matricula varchar(20) primary key,
    nome VARCHAR(45) not null,
    telefone varchar(45) not null,
    email varchar(45) not null,
    nota decimal(4,2),
    falta int
);

CREATE TABLE turma_aluno (
  matricula varchar(20) NOT NULL,
  idturma int(11) NOT NULL,
  foreign key (matricula) references aluno(matricula),
  foreign key (idturma) references turma(idturma)
)
