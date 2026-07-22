-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: localhost    Database: projeto_3r
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES ('admin','123456');
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curriculo`
--

DROP TABLE IF EXISTS `curriculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curriculo` (
  `cpf_egresso` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `informacoes_adicionais` text COLLATE utf8mb4_unicode_ci,
  `experiencia_profissional` text COLLATE utf8mb4_unicode_ci,
  `formacao` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`cpf_egresso`),
  CONSTRAINT `fk_curriculo_egresso` FOREIGN KEY (`cpf_egresso`) REFERENCES `egresso` (`cpf`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curriculo`
--

LOCK TABLES `curriculo` WRITE;
/*!40000 ALTER TABLE `curriculo` DISABLE KEYS */;
/*!40000 ALTER TABLE `curriculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso` (
  `id_curso` int NOT NULL AUTO_INCREMENT,
  `nome_curso` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carga_horaria` int NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `conteudo_programatico` text COLLATE utf8mb4_unicode_ci,
  `certificado` enum('Sim','Não') COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_curso` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egresso`
--

DROP TABLE IF EXISTS `egresso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egresso` (
  `cpf` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_interesse` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_perfil` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_recuperacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiracao_token` datetime DEFAULT NULL,
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egresso`
--

LOCK TABLES `egresso` WRITE;
/*!40000 ALTER TABLE `egresso` DISABLE KEYS */;
/*!40000 ALTER TABLE `egresso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egresso_curso`
--

DROP TABLE IF EXISTS `egresso_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egresso_curso` (
  `cpf_egresso` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_curso` int NOT NULL,
  `status_curso` enum('Em Andamento','Concluído') COLLATE utf8mb4_unicode_ci DEFAULT 'Em Andamento',
  PRIMARY KEY (`cpf_egresso`,`id_curso`),
  KEY `fk_egresso_curso_curso` (`id_curso`),
  CONSTRAINT `fk_egresso_curso_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE,
  CONSTRAINT `fk_egresso_curso_egresso` FOREIGN KEY (`cpf_egresso`) REFERENCES `egresso` (`cpf`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egresso_curso`
--

LOCK TABLES `egresso_curso` WRITE;
/*!40000 ALTER TABLE `egresso_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `egresso_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egresso_vaga`
--

DROP TABLE IF EXISTS `egresso_vaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egresso_vaga` (
  `id_candidatura` int NOT NULL AUTO_INCREMENT,
  `cpf_egresso` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_vaga` int NOT NULL,
  `data_candidatura` date DEFAULT (curdate()),
  `status_candidatura` enum('Em Análise','Aprovado','Rejeitado','Cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'Em Análise',
  PRIMARY KEY (`id_candidatura`),
  UNIQUE KEY `uk_candidatura` (`cpf_egresso`,`id_vaga`),
  KEY `fk_egresso_vaga_vaga` (`id_vaga`),
  CONSTRAINT `fk_egresso_vaga_egresso` FOREIGN KEY (`cpf_egresso`) REFERENCES `egresso` (`cpf`) ON DELETE CASCADE,
  CONSTRAINT `fk_egresso_vaga_vaga` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id_vaga`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egresso_vaga`
--

LOCK TABLES `egresso_vaga` WRITE;
/*!40000 ALTER TABLE `egresso_vaga` DISABLE KEYS */;
/*!40000 ALTER TABLE `egresso_vaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `cnpj` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rua` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complemento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_empresa` text COLLATE utf8mb4_unicode_ci,
  `logo_empresa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_recuperacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiracao_token` datetime DEFAULT NULL,
  `status_empresa` enum('Pendente','Aprovada','Rejeitada') COLLATE utf8mb4_unicode_ci DEFAULT 'Pendente',
  PRIMARY KEY (`cnpj`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaga`
--

DROP TABLE IF EXISTS `vaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaga` (
  `id_vaga` int NOT NULL AUTO_INCREMENT,
  `cnpj_empresa` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo_vaga` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requisitos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `beneficios` text COLLATE utf8mb4_unicode_ci,
  `carga_horaria` int NOT NULL,
  `faixa_salarial` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_contrato` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_vaga` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Aguardando Aprovação','Publicada','Rejeitada','Arquivada') COLLATE utf8mb4_unicode_ci DEFAULT 'Aguardando Aprovação',
  `data_aprovacao` date DEFAULT NULL,
  PRIMARY KEY (`id_vaga`),
  KEY `fk_vaga_empresa` (`cnpj_empresa`),
  CONSTRAINT `fk_vaga_empresa` FOREIGN KEY (`cnpj_empresa`) REFERENCES `empresa` (`cnpj`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaga`
--

LOCK TABLES `vaga` WRITE;
/*!40000 ALTER TABLE `vaga` DISABLE KEYS */;
/*!40000 ALTER TABLE `vaga` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-22 17:15:44
