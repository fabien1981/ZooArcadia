

CREATE DATABASE fabien31_arcadia ;
USE fabien31_arcadia ;

-- --------------------------------------------------------

--
-- Création de la table `animal`
CREATE TABLE `animal` (
  `animal_id` INT(11) NOT NULL AUTO_INCREMENT,
  `prenom` VARCHAR(50) DEFAULT NULL,
  `etat` VARCHAR(50) DEFAULT NULL,
  `race` VARCHAR(50) DEFAULT NULL,
  `image_animal` VARCHAR(50) DEFAULT NULL,
  `habitat` INT(11) DEFAULT NULL,
  PRIMARY KEY (`animal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données dans `animal`
INSERT INTO `animal` (`animal_id`, `prenom`, `etat`, `race`, `image_animal`, `habitat`) VALUES
(2, 'Starlion', 'Bon', 'Lion', 'lions2.png', 1),
(3, 'Gigi', 'En super forme', 'girafe', '../photos/girafe1.png', 1),
(4, 'Loulou', 'Correct', 'Loutre', 'loutre1.png', 3),
(92, 'Leo', 'Bon', 'Lion', 'lionceau2.png', 1),
(111, 'Tigrou', 'Bon', 'Tigre', 'tigre1.png', 2),
(113, 'Tank', 'Correct', 'Rhinocéros', 'rhino.jpg', 1);

-- Création de la table `habitat`
CREATE TABLE `habitat` (
  `habitat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `commentaire_habitat` TEXT DEFAULT NULL,
  `nom_image` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`habitat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données dans `habitat`
INSERT INTO `habitat` (`habitat_id`, `nom`, `description`, `commentaire_habitat`, `nom_image`) VALUES
(1, 'Savane', 'La savane', 'Découvrez l\'habitat de la Savane, un espace emblématique où se rencontrent les majestueux lions...', 'savane'),
(2, 'Jungle', 'La jungle', 'Plongez au cœur de la Jungle, un véritable écrin de biodiversité abritant des animaux exotiques...', 'jungle'),
(3, 'Marais', 'Le marais', 'Découvrez l\'univers unique du Marais, une zone humide vitale pour les crocodiles imposants...', 'marais');

-- Création de la table `nourriture`
CREATE TABLE `nourriture` (
  `nourriture_id` INT(11) NOT NULL AUTO_INCREMENT,
  `animal_id` INT(11) NOT NULL,
  `date_time` DATETIME NOT NULL,
  `type_nourriture` VARCHAR(255) NOT NULL,
  `quantite` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`nourriture_id`),
  KEY `animal_id` (`animal_id`),
  CONSTRAINT `nourriture_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données dans `nourriture`
INSERT INTO `nourriture` (`nourriture_id`, `animal_id`, `date_time`, `type_nourriture`, `quantite`) VALUES
(1, 111, '2024-11-29 13:43:00', 'salade', '10'),
(2, 2, '2024-11-15 18:57:00', 'salade', '3'),
(3, 2, '2024-11-20 20:59:00', 'zebre', '2000');

-- Création de la table `service`
CREATE TABLE `service` (
  `service_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données dans `service`
INSERT INTO `service` (`service_id`, `nom`, `description`, `image`) VALUES
(1, 'Restauration', 'Savourez la nature, respectez la planète 🌿\r\n\r\nBienvenue dans notre espace de restauration...', 'restaurant.jpeg'),
(2, 'Visites guidées', 'Explorez les secrets de la faune avec nos guides passionnés 🌍\r\n\r\nPartez à la découverte...', 'Designer (20).jpeg'),
(3, 'Arcadia Express', 'Embarquez pour un voyage unique au cœur de la nature 🚂🌿\r\n\r\nMontez à bord de notre petit train écologique...', 'train.png');

-- Création de la table `utilisateur`
CREATE TABLE `utilisateur` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `role_id` INT(11) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nom` VARCHAR(255) DEFAULT NULL,
  `prenom` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données dans `utilisateur`
INSERT INTO `utilisateur` (`user_id`, `email`, `role_id`, `password`, `nom`, `prenom`) VALUES
(13, 'jose@arcadia.com', 1, '$2y$10$pNrz5wM7DOVUDBhSdlGVc..03tiT.iZqBCCmiMsFJTd82ODDPmEse', 'Arcadia', 'José'),
(23, 'elise@arcadia.com', 3, '$2y$10$lCSsJkrBDpVpp3/74zjHuu9/5LhchKIk176dk42N0MK4Dov3LRqty', 'Dupont', 'Elise'),
(24, 'emma@arcadia.com', 2, '$2y$10$ruvupQVQo7RLr/Z5LbUVQutHKNeWhra4.3vqHtxvmrCPz60Q0ZWmW', 'Dupont', 'Emma');
