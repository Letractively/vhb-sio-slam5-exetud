-- --------------------------------------------------------
--
--
-- Création de la base de données stssio
DROP DATABASE IF EXISTS bdstssio;
CREATE DATABASE IF NOT EXISTS bdstssio
  CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------
--
-- création d'un utilisateur ayant tous les droits sur la base stssio
create user stssio@'localhost' identified by 'secret';
grant all on bdstssio.* to stssio@'localhost' ;

USE bdstssio;
-- --------------------------------------------------------
--
-- Structure de la table organisation
--
CREATE TABLE IF NOT EXISTS organisation (
  numero smallint(8) NOT NULL DEFAULT '0',
  nom varchar(100) DEFAULT NULL,
  rue varchar(100) DEFAULT NULL,
  cp varchar(6) DEFAULT NULL,
  ville varchar(100) DEFAULT NULL,
  tel varchar(50) DEFAULT NULL,
  fax varchar(50) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  urlSiteWeb varchar(100) DEFAULT NULL,
  PRIMARY KEY (numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Données de la table organisation
--
INSERT INTO organisation (numero, nom, rue, cp, ville, tel, fax, email, urlSiteWeb) VALUES
(1, 'Rectorat de Rennes', '96 rue d''Antrain', '35000', 'Rennes', '02 23 21 77 77', '', NULL, NULL),
(2, 'IRISA', 'Campus de Beaulieu', '35042', 'Rennes Cedex', '02 99 84 71 00', '02 99 84 71 71', '', 'www.irisa.fr'),
(3, 'SOLLEIL', '3 rue de la Carrière', '35920', 'Rennes', '02 99 14 40 70', '', 'solleil@solleil.fr', 'www.solleil.fr'),
(4, 'Lycée Victor et Hélène Basch', '15 avenue Charles Tillon', '35000', 'Rennes', '0299544443', '', '', 'lidf.homeip.net'),
(5, 'Lycée professionnel Coëtlogon', 'Rue Antoine Joly - BP 18307', '35083', 'Rennes Cedex', '02 99 54 62 62', NULL, NULL, NULL),
(6, 'Informatique Tech Service', 'ZI du Dressère', '56150', 'Baud', '02 97 51 80 20', '02 97 51 87 83', NULL, NULL),
(7, 'JET PRINT''S 35', '8 rue de la Garenne', '35135', 'Chantepie', '06 60 70 25 28', '08 25 14 62 61', NULL, 'www.jetprints35.fr'),
(8, 'SIB - Syndicat Interhospitalier de Bretagne', '4 rue du Professeur Jean Pecker', '35000', 'Rennes', '02 99 54 75 10', '02 99 54 75 09', NULL, 'www.sib.fr'),
(9, 'CFP - Brest', '15 Place Sanquer', '29200', 'Brest', '02 98 44 29 33', '02 99 44 51 10', NULL, 'www.cfp29.org'),
(10, 'AGI Informatique', '332 rue de Nantes', '35200', 'Rennes', '02 99 50 70 39', '02 9932 04 16', NULL, NULL),
(11, 'France Télécom - Orange Business Services', '9, rue du Chêne germain', '35512', 'Cesson-Sévigné', '02 23 28 30 30', NULL, NULL, 'www.orange-business.com'),
(12, 'DRE Bretagne', '10, rue Maurice Fabre CS 96515', '35065', 'Rennes cedex', '02 99 33 45 55', '02 99 33 44 33', 'DRE-Bretagne@developpement-durable.gouv.fr', 'www.bretagne.equipement.gouv.fr'),
(13, 'Ecole des Métiers de l''Environnement', 'Campus de Ker Lann - Boulevard Robert Schumann', '35170', 'Bruz', '02 99 05 88 00', '02 99 05 88 09', NULL, 'www.ecole-eme.com'),
(14, 'BSH Constructions et Rénovations', '5, venelle des Anglais', '22450', 'La Roche Derrien', NULL, NULL, NULL, NULL),
(15, 'Poste - DSI', '11, rue Vaneau - BP 13282', '35032', 'Rennes cedex', NULL, NULL, NULL, NULL),
(16, 'Lenerrant', 'ZI du Placis', '35230', 'Bourgbarré', '02.99.00.45.00', '02.99.00.40.02', NULL, NULL),
(17, 'AT & MIS', '40 rue du Bignon', '35135', 'Chantepie', '02 99 86 30 37', NULL, NULL, NULL),
(18, 'CAF Ille et Vilaine', 'Cours des Alliés', '35028', 'Rennes Cedex 9', '02 99 29 19 54', '02 99 30 54 71', NULL, 'www.caf.fr'),
(19, 'Lycée-Collège Saint-Pierre', '16, rue Saint-Pierre', '22015', 'Saint-Brieuc', '02 96 68 58 00', NULL, NULL, NULL),
(20, 'Clinique de la Porte de l''Orient', '3 rue Robert de la Croix', '56100', 'Lorient', '02 97 64 81 54', '02 97 64 81 10', NULL, NULL),
(21, 'SDI', 'Parc de Beaujardin', '35410', 'Chateaugiron', '0299372450', NULL, NULL, 'www.sdi-info.com'),
(22, 'Wizdeo', '18 rue de la Rigourdière', '35510', 'Cesson-Sévigné', '02 99 83 44 71', NULL, NULL, 'www.wizdeo.com'),
(23, 'Correspondance France-Chine', '3 rue Lécuyer', '75018', 'Paris', '01 55 28 60 35', NULL, NULL, 'infoschinefrance.com'),
(25, 'Ecole de Reconversion Professionnelle Jean Janvier', '11 rue Edouard Vaillant', '35000', 'Rennes', NULL, '02 99 59 14 47', NULL, 'www.erp.rennes.emac.org'),
(26, 'Clinique La Sagesse', '4 place Saint-Guénolé - CS 44345', '35043', 'Rennes', '02 99 85 75 75', '02 99 85 76 00', NULL, NULL),
(27, 'Groupe CPA - Cliniques Privées Associées', '10 Boulevard de la Boutière', '35760', 'Saint-Grégoire', '02 99 23 93 41', NULL, NULL, NULL),
(28, 'Kit-PC', '4 rue Belle-Ile', '35760', 'Saint-Grégoire', '02 23 25 01 95', '02 23 25 01 89', NULL, 'www.kit-pc.fr'),
(29, 'Centre Médecine Physique Réadaptation ND Lourdes', '54 rue Saint-Hélier', '35000', 'Rennes', '02 99 29 50 99', NULL, NULL, NULL),
(30, 'Chambre d''Agriculture', 'Rue Le Lannov - CS 14226', '35042', 'Rennes Cedex', '02 23 48 23 23', '02 23 48 23 25', NULL, 'www.sinagri.com'),
(31, 'ICNS', '48 rue de Lorient', '35000', 'Rennes', '02 99 33 72 52', NULL, NULL, 'www.icns.fr'),
(32, 'Mairie de Bourgbarré', '1 rue des Sports', '35150', 'Bourgbarré', '02 99 57 66 96', '02 99 57 70 60', 'mairie@bourgbarre.fr', 'www.bourgbarre.fr'),
(33, 'Point P Bretagne', '23 Boulevard de la Haie des Cognets', '35136', 'Saint-Jacques de la Lande', '02 99 65 20 20', '02 99 65 20 16', NULL, 'www.groupe.pointp.fr'),
(34, 'Logidis Comptoirs Modernes Carrefour', 'ZAC des Cormiers', '35650', 'Le Rheu', NULL, '02 99 14 76 79', NULL, NULL),
(35, 'Digital DC Système', 'Bâtiment B - Rue Pierre de maupertuis', '35170', 'Bruz', '02 99 57 90 74', NULL, NULL, NULL),
(36, 'Société Quincaillerie Boschat', 'Route de Plancoët - BP 347', '22403', 'Lamballe Cedex', NULL, NULL, NULL, NULL),
(37, 'Stade Rennais', 'La Piverdière CS 53909', '35039', 'Rennes', NULL, NULL, NULL, 'www.staderennais.com');
