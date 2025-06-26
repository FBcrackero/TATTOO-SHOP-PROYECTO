-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gestion_tattoo_shop
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo` (
  `idCargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCargo` varchar(40) DEFAULT NULL,
  `descripcionCargo` varchar(60) DEFAULT NULL,
  `nomenclaturaCargo` char(3) DEFAULT NULL,
  `sueldo` double DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCargo`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `cargo_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Artista','Encargado de realizar tatuajes o perforaciones','ART',1000000,1),(2,'CargoEjemplo','EjemploC','CRG',2,1);
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoriaproductos`
--

DROP TABLE IF EXISTS `categoriaproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoriaproductos` (
  `idCategoriaProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoriaProducto` varchar(40) DEFAULT NULL,
  `descripcionCategoriaProducto` varchar(60) DEFAULT NULL,
  `nomenclaturaCategoriaProducto` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCategoriaProducto`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `categoriaproductos_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoriaproductos`
--

LOCK TABLES `categoriaproductos` WRITE;
/*!40000 ALTER TABLE `categoriaproductos` DISABLE KEYS */;
INSERT INTO `categoriaproductos` VALUES (1,'Tinta','Tintas para tatuar','TINT',1),(2,'Agujas','Agujas para m?quinas de tatuar','AGUJ',1),(3,'M?quinas','M?quinas de tatuar','MAQ',1),(4,'Accesorios','Accesorios varios','ACCE',1),(5,'Piel sintetica','Elemento para practicas','PST',1);
/*!40000 ALTER TABLE `categoriaproductos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudad` (
  `idCiudad` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCiudad` varchar(40) DEFAULT NULL,
  `descripcionCiudad` varchar(60) DEFAULT NULL,
  `idDepartamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCiudad`),
  KEY `idDepartamento` (`idDepartamento`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudad`
--

LOCK TABLES `ciudad` WRITE;
/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
INSERT INTO `ciudad` VALUES (1,'Medellín','Ciudad de Medellín',1),(2,'Medellin','Ciudad de Medellin',1),(3,'Bello','Ciudad de Bello',1),(4,'Leticia','Ciudad de Leticia',2),(5,'Puerto Narino','Ciudad de Puerto Narino',2),(6,'Arauca','Ciudad de Arauca',3),(7,'Tame','Ciudad de Tame',3),(8,'Barranquilla','Ciudad de Barranquilla',4),(9,'Soledad','Ciudad de Soledad',4),(10,'Cartagena','Ciudad de Cartagena',5),(11,'Magangue','Ciudad de Magangue',5),(12,'Tunja','Ciudad de Tunja',6),(13,'Duitama','Ciudad de Duitama',6),(14,'Manizales','Ciudad de Manizales',7),(15,'La Dorada','Ciudad de La Dorada',7),(16,'Florencia','Ciudad de Florencia',8),(17,'San Vicente del Caguan','Ciudad de San Vicente del Caguan',8),(18,'Yopal','Ciudad de Yopal',9),(19,'Aguazul','Ciudad de Aguazul',9),(20,'Popayan','Ciudad de Popayan',10),(21,'Santander de Quilichao','Ciudad de Santander de Quilichao',10),(22,'Valledupar','Ciudad de Valledupar',11),(23,'Aguachica','Ciudad de Aguachica',11),(24,'Quibdo','Ciudad de Quibdo',12),(25,'Istmina','Ciudad de Istmina',12),(26,'Monteria','Ciudad de Monteria',13),(27,'Lorica','Ciudad de Lorica',13),(28,'Zipaquira','Ciudad de Zipaquira',14),(29,'Facatativa','Ciudad de Facatativa',14),(30,'Inirida','Ciudad de Inirida',15),(31,'Barranco Minas','Ciudad de Barranco Minas',15),(32,'San Jose del Guaviare','Ciudad de San Jose del Guaviare',16),(33,'Calamar','Ciudad de Calamar',16),(34,'Neiva','Ciudad de Neiva',17),(35,'Pitalito','Ciudad de Pitalito',17),(36,'Riohacha','Ciudad de Riohacha',18),(37,'Maicao','Ciudad de Maicao',18),(38,'Santa Marta','Ciudad de Santa Marta',19),(39,'Fundacion','Ciudad de Fundacion',19),(40,'Villavicencio','Ciudad de Villavicencio',20),(41,'Acacias','Ciudad de Acacias',20),(42,'Pasto','Ciudad de Pasto',21),(43,'Tumaco','Ciudad de Tumaco',21),(44,'Cucuta','Ciudad de Cucuta',22),(45,'Oca?a','Ciudad de Ocana',22),(46,'Mocoa','Ciudad de Mocoa',23),(47,'Puerto Asis','Ciudad de Puerto Asis',23),(48,'Armenia','Ciudad de Armenia',24),(49,'Montenegro','Ciudad de Montenegro',24),(50,'Pereira','Ciudad de Pereira',25),(51,'Dosquebradas','Ciudad de Dosquebradas',25),(52,'San Andres','Ciudad de San Andres',26),(53,'Providencia','Ciudad de Providencia',26),(54,'Bucaramanga','Ciudad de Bucaramanga',27),(55,'Floridablanca','Ciudad de Floridablanca',27),(56,'Sincelejo','Ciudad de Sincelejo',28),(57,'Corozal','Ciudad de Corozal',28),(58,'Ibague','Ciudad de Ibague',29),(59,'Espinal','Ciudad de Espinal',29),(60,'Cali','Ciudad de Cali',30),(61,'Palmira','Ciudad de Palmira',30),(62,'Mitu','Ciudad de Mitu',31),(63,'Caruru','Ciudad de Caruru',31),(64,'Puerto Carreno','Ciudad de Puerto Carreno',32),(65,'La Primavera','Ciudad de La Primavera',32),(66,'Bogota','Ciudad de Bogota',33),(67,'Usme','Ciudad de Usme',33);
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDepartamento` varchar(40) DEFAULT NULL,
  `descripcionDepartamento` varchar(60) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDepartamento`),
  KEY `idPais` (`idPais`),
  CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`idPais`) REFERENCES `pais` (`idPais`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'Antioquia','Departamento de Antioquia',1),(2,'Amazonas','Departamento de Amazonas',1),(3,'Arauca','Departamento de Arauca',1),(4,'Atlantico','Departamento de Atlantico',1),(5,'Bolivar','Departamento de Bolivar',1),(6,'Boyaca','Departamento de Boyaca',1),(7,'Caldas','Departamento de Caldas',1),(8,'Caqueta','Departamento de Caqueta',1),(9,'Casanare','Departamento de Casanare',1),(10,'Cauca','Departamento del Cauca',1),(11,'Cesar','Departamento del Cesar',1),(12,'Choco','Departamento del Choco',1),(13,'Cordoba','Departamento de Cordoba',1),(14,'Cundinamarca','Departamento de Cundinamarca',1),(15,'Guainia','Departamento de Guainia',1),(16,'Guaviare','Departamento de Guaviare',1),(17,'Huila','Departamento del Huila',1),(18,'La Guajira','Departamento de La Guajira',1),(19,'Magdalena','Departamento del Magdalena',1),(20,'Meta','Departamento del Meta',1),(21,'Narino','Departamento de Narino',1),(22,'Norte de Santander','Departamento de Norte de Santander',1),(23,'Putumayo','Departamento del Putumayo',1),(24,'Quindio','Departamento del Quindio',1),(25,'Risaralda','Departamento de Risaralda',1),(26,'San Andres y Providencia','Departamento de San Andres y Providencia',1),(27,'Santander','Departamento de Santander',1),(28,'Sucre','Departamento de Sucre',1),(29,'Tolima','Departamento del Tolima',1),(30,'Valle del Cauca','Departamento del Valle del Cauca',1),(31,'Vaupes','Departamento de Vaupes',1),(32,'Vichada','Departamento de Vichada',1),(33,'Bogota D.C.','Distrito Capital',1);
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `fechaVinculacionEmpleado` date DEFAULT NULL,
  `numeroContrato` int(11) DEFAULT NULL,
  `idCargo` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEmpleado`),
  KEY `idCargo` (`idCargo`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idCargo`) REFERENCES `cargo` (`idCargo`),
  CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `empleado_ibfk_3` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'2025-06-23',12345,1,4,1);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEstado` varchar(30) DEFAULT NULL,
  `descripcionEstado` varchar(60) DEFAULT NULL,
  `nomenclaturaEstado` char(4) DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Disponible','Estado disponible.','DIS'),(2,'No disponible','Estado no disponible','NDIS'),(3,'Pendiente','Reserva pendiente de aprobaci?n','PEN'),(4,'Aceptada','Reserva aceptada','ACE'),(5,'Cancelada','Reserva cancelada por el usuario','CAN'),(6,'Rechazada','Reserva rechazada por el artista','REC');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `codFacturaProducto` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `idFormaPago` int(11) DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `ultimosTarjeta` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`codFacturaProducto`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idFormaPago` (`idFormaPago`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`idFormaPago`) REFERENCES `formapago` (`idFormaPago`),
  CONSTRAINT `factura_ibfk_4` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (8,3,2,'2025-06-25',1,'9876'),(9,8,2,'2025-06-25',1,'8765'),(10,8,2,'2025-06-25',1,'2345');
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturaproducto`
--

DROP TABLE IF EXISTS `facturaproducto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facturaproducto` (
  `codFacturaProducto` int(11) NOT NULL,
  `codProducto` int(11) NOT NULL,
  `fechaFacturaProducto` date DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`codFacturaProducto`,`codProducto`),
  KEY `codProducto` (`codProducto`),
  CONSTRAINT `facturaproducto_ibfk_1` FOREIGN KEY (`codFacturaProducto`) REFERENCES `factura` (`codFacturaProducto`),
  CONSTRAINT `facturaproducto_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturaproducto`
--

LOCK TABLES `facturaproducto` WRITE;
/*!40000 ALTER TABLE `facturaproducto` DISABLE KEYS */;
INSERT INTO `facturaproducto` VALUES (8,2,'2025-06-25',1),(9,2,'2025-06-25',3),(10,2,'2025-06-25',2);
/*!40000 ALTER TABLE `facturaproducto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formapago`
--

DROP TABLE IF EXISTS `formapago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formapago` (
  `idFormaPago` int(11) NOT NULL AUTO_INCREMENT,
  `nombreFormaPago` varchar(40) DEFAULT NULL,
  `descripcionFormaPago` varchar(60) DEFAULT NULL,
  `nomenclaturaFormaPago` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT 1,
  PRIMARY KEY (`idFormaPago`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formapago`
--

LOCK TABLES `formapago` WRITE;
/*!40000 ALTER TABLE `formapago` DISABLE KEYS */;
INSERT INTO `formapago` VALUES (2,'VISA','Tarjeta VISA','VIS',1);
/*!40000 ALTER TABLE `formapago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genero` (
  `idGenero` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGenero` varchar(40) DEFAULT NULL,
  `descripcionGenero` varchar(60) DEFAULT NULL,
  `nomenclaturaGenero` char(4) DEFAULT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero`
--

LOCK TABLES `genero` WRITE;
/*!40000 ALTER TABLE `genero` DISABLE KEYS */;
INSERT INTO `genero` VALUES (1,'Masculino','G?nero masculino','M'),(2,'Femenino','G?nero femenino','FEM');
/*!40000 ALTER TABLE `genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kardex`
--

DROP TABLE IF EXISTS `kardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kardex` (
  `idKardex` int(11) NOT NULL AUTO_INCREMENT,
  `cantKardEntrada` int(11) DEFAULT NULL,
  `cantKardSalida` int(11) DEFAULT NULL,
  `precioVenta` double DEFAULT NULL,
  `fechaInventario` date DEFAULT NULL,
  `codProducto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idKardex`),
  KEY `codProducto` (`codProducto`),
  CONSTRAINT `kardex_ibfk_1` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kardex`
--

LOCK TABLES `kardex` WRITE;
/*!40000 ALTER TABLE `kardex` DISABLE KEYS */;
INSERT INTO `kardex` VALUES (1,0,1,160000,'2025-06-25',2),(2,10,0,50,'2025-06-25',1),(3,12,0,160000,'2025-06-25',2),(4,0,3,160000,'2025-06-25',2),(5,0,2,160000,'2025-06-25',2);
/*!40000 ALTER TABLE `kardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `idPais` int(11) NOT NULL AUTO_INCREMENT,
  `nombrePais` varchar(40) DEFAULT NULL,
  `descripcionPais` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`idPais`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Colombia','Pa?s Colombia');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechaPedido` date DEFAULT NULL,
  `direccionPedido` varchar(50) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidadProducto` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCiudad` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `idProducto` (`idProducto`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idCiudad` (`idCiudad`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`codProducto`),
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`idCiudad`) REFERENCES `ciudad` (`idCiudad`),
  CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombrePerfil` varchar(40) DEFAULT NULL,
  `descripcionPerfil` varchar(60) DEFAULT NULL,
  `nomenclaturaPerfil` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'admin','Administrador del sistema','ADM',1),(2,'Usuario','Usuario registrado que puede reservar servicios','USR',NULL),(3,'Empleado','Empleado que presta servicios art?sticos','EMP',1);
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `codProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(40) DEFAULT NULL,
  `descripcionProducto` varchar(60) DEFAULT NULL,
  `nomenclaturaProducto` varchar(4) NOT NULL,
  `imagenProducto` varchar(250) DEFAULT NULL,
  `precioCompra` double DEFAULT NULL,
  `stockMax` int(11) DEFAULT NULL,
  `stockMin` int(11) DEFAULT NULL,
  `cantidadDisponible` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `idUnidadMedida` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`codProducto`),
  KEY `idCategoria` (`idCategoria`),
  KEY `idUnidadMedida` (`idUnidadMedida`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoriaproductos` (`idCategoriaProducto`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`idUnidadMedida`) REFERENCES `unidadmedida` (`idUnidadMedida`),
  CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Tinta vegetal','Hecha a base de ingredientes naturales','TINV','tinta_vegetal.png',50,100,1,20,1,2,1),(2,'Maquina rotativa','Utilizan un motor eléctrico para mover la aguja.','MQR','Maquina_tatuar.png',160000,20,10,21,3,1,1),(3,'Azul Estelar Ear Set.','Conjunto de piercings de ear con piedras azules.','AEES','piedras_azules.png',200000,200,100,150,4,1,1),(4,'Estrella Lunar Piercing.','Barra de piercing con curva y colgante estrella.','ESLP','barra_piercing.png',300000,1000,2,20,4,1,1),(6,'Lujo Celestial Clip','Pendiente clip con cadena y cruces brillantes','LUCC','lujo_celestial.png',3000000,15,10,1,4,1,1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL AUTO_INCREMENT,
  `horaReserva` time DEFAULT NULL,
  `fechaReserva` date DEFAULT NULL,
  `descripcionReserva` varchar(255) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idArtista` int(11) DEFAULT NULL,
  `idServicio` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idServicio` (`idServicio`),
  KEY `idEstado` (`idEstado`),
  KEY `fk_idArtista` (`idArtista`),
  CONSTRAINT `fk_estado_reserva` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`),
  CONSTRAINT `fk_idArtista` FOREIGN KEY (`idArtista`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`),
  CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,'17:02:00','2025-06-30','Una tatuaje',3,4,1,3),(2,'17:24:00','2025-06-30','Tatuaje antebrazo',3,4,1,6),(3,'17:27:00','2025-06-30','Pues un piercing de esos',3,4,4,4),(4,'09:41:00','2025-08-21','Me quiero cortar la cara',3,4,8,6),(6,'13:26:00','2025-06-24','Eso',3,4,1,5),(8,'22:32:00','2025-07-08','Escarficacosa',7,4,8,3);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombreServicio` varchar(40) DEFAULT NULL,
  `descripcionServicio` varchar(60) DEFAULT NULL,
  `nomenclaturaServicio` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `imagenServicio` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idServicio`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (1,'Tatuaje Pequeño','Diseño simple, hasta 5cm','TPQ',2,'tatuaje_pequeño.png'),(2,'Tatuaje Mediano','Diseño mediano, hasta 15cm','TMD',1,'tatuaje_mediano.png'),(3,'Tatuaje Grande','Diseño grande, más de 15 cm','TTA',1,'1750491777_imagen_2025-06-21_024250877.png'),(4,'Perforación: Piercing Helix','Perforación en el cartílago superior de la oreja','PPH',1,'perforacion-piercing-helix-1750543758.png'),(5,'Perforación: Piercing Industrial','Perforación que conecta dos puntos del cartílago superior','PPI',1,'perforacion-piercing-industrial-1750545046.png'),(7,'Perforación: Piercing Labret','Perforación en el labio','PPL',1,'perforacion-piercing-labret-1750554084.png'),(8,'Escarificación','Cortes en la piel para crear cicatrices decorativas','ESC',1,'escarificacion-1750627946.png');
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipodocumento` (
  `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTipoDoc` varchar(30) DEFAULT NULL,
  `descripcionTipoDoc` varchar(60) DEFAULT NULL,
  `nomenclaturaTipoDoc` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTipoDocumento`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `tipodocumento_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipodocumento`
--

LOCK TABLES `tipodocumento` WRITE;
/*!40000 ALTER TABLE `tipodocumento` DISABLE KEYS */;
INSERT INTO `tipodocumento` VALUES (1,'Cédula','Cédula de ciudadanía','CC',1);
/*!40000 ALTER TABLE `tipodocumento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidadmedida`
--

DROP TABLE IF EXISTS `unidadmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidadmedida` (
  `idUnidadMedida` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUnidadMedida` varchar(40) DEFAULT NULL,
  `descripcionUnidadMedida` varchar(60) DEFAULT NULL,
  `nomenclaturaUnidadMedida` char(4) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUnidadMedida`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `unidadmedida_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidadmedida`
--

LOCK TABLES `unidadmedida` WRITE;
/*!40000 ALTER TABLE `unidadmedida` DISABLE KEYS */;
INSERT INTO `unidadmedida` VALUES (1,'Unidad','Unidad individual','UND',1),(2,'Mililitro','Volumen en mililitros','ML',1),(3,'Gramo','Peso en gramos','GR',1),(4,'Centímetro','Longitud en centímetros','CM',1);
/*!40000 ALTER TABLE `unidadmedida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombresUsu` varchar(40) DEFAULT NULL,
  `apellidosUsu` varchar(40) DEFAULT NULL,
  `celularUsu` varchar(10) DEFAULT NULL,
  `NidentificacionUsu` varchar(20) DEFAULT NULL,
  `fechaNacUsu` date DEFAULT NULL,
  `emailUsu` varchar(60) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `idTipoDocumento` int(11) DEFAULT NULL,
  `idPerfil` int(11) DEFAULT NULL,
  `idCiudad` int(11) DEFAULT NULL,
  `idGenero` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idTipoDocumento` (`idTipoDocumento`),
  KEY `idPerfil` (`idPerfil`),
  KEY `idCiudad` (`idCiudad`),
  KEY `idGenero` (`idGenero`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idTipoDocumento`) REFERENCES `tipodocumento` (`idTipoDocumento`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`),
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`idCiudad`) REFERENCES `ciudad` (`idCiudad`),
  CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`),
  CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador','Principal','3000000000','12345678','1990-01-01','admin@tattooshop.com','$2y$12$JoK0TXXguMUf7UGSKFv43eVwYSyCmr3AarL4QwEtbOg8TqcFKxWIG',1,1,1,1,1),(3,'Diana','Hernandez','314672876','121212122','2005-03-08','diana@gmail.com','$2y$12$kW7RT5DJKD/9uS0vOYF/TO229gaQMJm6gwY8xgAnacRcJr7BnmE6u',1,2,1,2,1),(4,'Carlos','Belcast','3201020192','12312312313','2006-06-07','carlosb@artist.com','$2y$12$mRm.qq5mylgi3vtn9hZ0nOIws2Y.awxt8Rm6q1RhHjmXOBSIzQmau',1,3,1,1,1),(7,'ejemplo','ejemp','1324567890','1324567890','1989-06-05','ejemplo@ejemplo.com','$2y$12$S0ecIpnYTqtUwZCLu7m9Le4/OSVaHHCqEl9uCfTsD8/F4z4b4aQRu',1,2,1,1,1),(8,'Johan','Ejemplo','3333333333','0987654321','2003-08-24','johan@ejemplo.com','$2y$12$Ct//w5TUCDG8fsaA9iId5OsNHW88wP1WvJxmWthX946bLID7Y.bfK',1,2,1,1,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-25 17:29:17
