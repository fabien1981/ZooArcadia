-- MySQL dump 10.13  Distrib 8.0.39, for Win64 (x86_64)
--
-- Host: mysql-fabien31.alwaysdata.net    Database: fabien31_arcadia
-- ------------------------------------------------------
-- Server version	5.5.5-10.11.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `animal`
--

DROP TABLE IF EXISTS `animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animal` (
  `animal_id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `race` varchar(50) DEFAULT NULL,
  `image_animal` varchar(50) DEFAULT NULL,
  `habitat` int(11) DEFAULT NULL,
  PRIMARY KEY (`animal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal`
--

LOCK TABLES `animal` WRITE;
/*!40000 ALTER TABLE `animal` DISABLE KEYS */;
INSERT INTO `animal` VALUES (2,'Starlion','Bon','Lion','lions2.png',1),(3,'Gigi','Fatigué','girafe','../photos/girafe1.png',1),(4,'Loulou','Correct','Loutre','loutre1.png',3),(111,'Tigrou','En super forme','Tigre','tigre1.png',2),(113,'Tank','Correct','Rhinocéros','rhino.jpg',1),(114,'Léo','En super forme','Lion','lionceau2.png',1),(115,'Babar','En super forme','Eléphant','elephantzoo.jpg',1);
/*!40000 ALTER TABLE `animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitat`
--

DROP TABLE IF EXISTS `habitat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitat` (
  `habitat_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `commentaire_habitat` text DEFAULT NULL,
  `nom_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`habitat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitat`
--

LOCK TABLES `habitat` WRITE;
/*!40000 ALTER TABLE `habitat` DISABLE KEYS */;
INSERT INTO `habitat` VALUES (1,'Savane','La savane','Découvrez l\'habitat de la Savane, un espace emblématique où se rencontrent les majestueux lions, les éléphants imposants, les zèbres aux rayures uniques et bien d\'autres espèces fascinantes de la faune africaine. Dans notre zoo écologique et écoresponsable, cet habitat est conçu pour offrir aux animaux un environnement aussi proche que possible de leur milieu naturel.','savane'),(2,'Jungle','La jungle','Plongez au cœur de la Jungle, un véritable écrin de biodiversité abritant des animaux exotiques tels que les jaguars furtifs, les oiseaux multicolores et les singes agiles. Notre habitat recrée l\'atmosphère dense et luxuriante des forêts tropicales, un refuge essentiel pour ces espèces fascinantes. Dans notre démarche écoresponsable, cet espace est conçu pour sensibiliser les visiteurs à l\'importance de préserver les jungles du monde, véritables poumons de la planète et sanctuaires de la vie sauvage.','jungle'),(3,'Marais','Le marais','Découvrez l\'univers unique du Marais, une zone humide vitale pour les crocodiles imposants, les loutres joueuses et les hérons élégants. Ce lieu, recréé avec soin, met en valeur l\'importance des marais dans l\'équilibre des écosystèmes, en filtrant naturellement l\'eau et en offrant un habitat crucial pour de nombreuses espèces. Engagé dans une approche écologique, notre zoo intègre des techniques durables pour maintenir cet habitat, tout en sensibilisant les visiteurs à la conservation des zones humides, indispensables à la survie de nombreuses formes de vie.','marais');
/*!40000 ALTER TABLE `habitat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horaires`
--

DROP TABLE IF EXISTS `horaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(255) NOT NULL,
  `fermeture_caisses` varchar(255) NOT NULL,
  `fermeture_parc_pied` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horaires`
--

LOCK TABLES `horaires` WRITE;
/*!40000 ALTER TABLE `horaires` DISABLE KEYS */;
INSERT INTO `horaires` VALUES (3,'01/12/24 - 31/12/25','18:00','19:00');
/*!40000 ALTER TABLE `horaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nourriture`
--

DROP TABLE IF EXISTS `nourriture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nourriture` (
  `nourriture_id` int(11) NOT NULL AUTO_INCREMENT,
  `animal_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `type_nourriture` varchar(255) NOT NULL,
  `quantite` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`nourriture_id`),
  KEY `animal_id` (`animal_id`),
  KEY `fk_user` (`user_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `nourriture_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nourriture`
--

LOCK TABLES `nourriture` WRITE;
/*!40000 ALTER TABLE `nourriture` DISABLE KEYS */;
INSERT INTO `nourriture` VALUES (6,3,'2025-01-02 15:15:00','viande','5000',24),(7,2,'2025-01-02 15:22:00','viande','5000',24),(11,4,'2025-01-02 20:03:00','kiwi','200',23),(12,113,'2025-01-02 20:04:00','potiron','5000',23),(13,114,'2025-01-02 20:38:00','viande','2000',23),(14,2,'2025-01-05 14:02:00','viande','5000',23),(15,115,'2025-01-05 14:05:00','carotte','5000',23);
/*!40000 ALTER TABLE `nourriture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race`
--

DROP TABLE IF EXISTS `race`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `race` (
  `race_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`race_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race`
--

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
/*!40000 ALTER TABLE `race` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rapport_veterinaire`
--

DROP TABLE IF EXISTS `rapport_veterinaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rapport_veterinaire` (
  `rapport_veterinaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `nourriture` varchar(255) DEFAULT NULL,
  `grammage` varchar(255) DEFAULT NULL,
  `animal_id` int(11) NOT NULL,
  PRIMARY KEY (`rapport_veterinaire_id`),
  KEY `fk_animal_id` (`animal_id`),
  CONSTRAINT `fk_animal` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_animal_id` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rapport_veterinaire`
--

LOCK TABLES `rapport_veterinaire` WRITE;
/*!40000 ALTER TABLE `rapport_veterinaire` DISABLE KEYS */;
INSERT INTO `rapport_veterinaire` VALUES (1,'2024-12-31','habitat propre','bon','kiwi','200',4),(3,'2024-12-31','a besoin de plus d\'eau','bon','viande','5000',2),(6,'2024-12-31','RAS','bon','potiron','5000',113),(23,'2025-01-01','bon','Fatigué','viande','5000',3),(24,'2025-01-01','Animal heureux','En super forme','viande','5000',111),(25,'2025-01-02','Beaucoup d\'énergie et très curieux','En super forme','viande','2000',114),(26,'2025-01-05','Dort beaucoup','Bon','viande','5000',2),(27,'2025-01-05','Se plait beaucoup dans son enclos','En super forme','carotte','5000',115),(28,'2025-01-05','La star de son enclos!','Correct','potiron','5000',113);
/*!40000 ALTER TABLE `rapport_veterinaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin'),(2,'Vétérinaire'),(3,'Employé');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'Restauration','Savourez la nature, respectez la planète 🌿\r\n\r\nBienvenue dans notre espace de restauration au cœur du zoo Arcadia ! Dégustez des plats savoureux, préparés avec des ingrédients locaux et de saison. Profitez d’une vue imprenable sur les habitats naturels des animaux tout en respectant l’environnement grâce à nos pratiques zéro déchet.\r\n\r\nUne expérience gourmande au plus près de la nature !','restaurant.jpeg'),(2,'Visites guidées','Explorez les secrets de la faune avec nos guides passionnés 🌍\r\n\r\nPartez à la découverte des habitats uniques de nos animaux grâce à nos visites guidées gratuites ! Nos guides experts vous emmènent au cœur de la nature pour vous révéler les merveilles de la biodiversité et les secrets de chaque espèce. Une expérience immersive et enrichissante, au plus près des animaux, dans un zoo engagé pour l’écologie.\r\n\r\nApprenez, émerveillez-vous, et contribuez à la préservation de la planète !','Designer (20).jpeg'),(3,'Arcadia Express','Embarquez pour un voyage unique au cœur de la nature 🚂🌿\r\n\r\nMontez à bord de notre petit train écologique et laissez-vous transporter à travers les habitats des animaux. Une manière douce et respectueuse de découvrir le zoo, tout en profitant d’une vue panoramique sur des espèces fascinantes dans leur environnement naturel.\r\n\r\nUn moment ludique et écoresponsable pour petits et grands !','train.png');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (13,'jose@arcadia.com',1,'$2y$10$pNrz5wM7DOVUDBhSdlGVc..03tiT.iZqBCCmiMsFJTd82ODDPmEse','Arcadia','José'),(23,'elise@arcadia.com',3,'$2y$10$lCSsJkrBDpVpp3/74zjHuu9/5LhchKIk176dk42N0MK4Dov3LRqty','Dupont','Elise'),(24,'emma@arcadia.com',2,'$2y$10$ruvupQVQo7RLr/Z5LbUVQutHKNeWhra4.3vqHtxvmrCPz60Q0ZWmW','Dupont','Emma'),(38,'julliafabien@gmail.com',3,'$2y$12$eOlxqUtnuWNWjlJH8tLnfeqlOHnN1pi4f4EeB3qeh1ocZZaSMPz6e','jullia','fabien');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-15 14:29:51
