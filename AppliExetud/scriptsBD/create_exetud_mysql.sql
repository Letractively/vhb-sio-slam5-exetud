-- ----------------------------------------------------------------------
-- MySQL Migration Toolkit
-- SQL Create Script
-- ----------------------------------------------------------------------

DROP DATABASE IF EXISTS `bdExetud`;
CREATE DATABASE IF NOT EXISTS `bdExetud`
  CHARACTER SET utf8 COLLATE utf8_general_ci;
-- création d'un utilisateur ayant tous les droits sur la base bdExetud
-- au préalable on le supprime
drop user userExetud@'localhost';
create user userExetud@'localhost' identified by 'secret';
grant all on bdExetud.* to userExetud@'localhost' ;

USE `bdExetud`;
-- -------------------------------------
-- Tables

DROP TABLE IF EXISTS `DOMAINE`;
CREATE TABLE `DOMAINE` (
  `code_domaine` VARCHAR(3) NOT NULL,
  `lib_domaine` VARCHAR(128) NULL,
  PRIMARY KEY (`code_domaine`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `ENTREPRISE`;
CREATE TABLE `ENTREPRISE` (
  `num_ent` INT(10) NOT NULL AUTO_INCREMENT,
  `code_domaine` VARCHAR(3) NULL,
  `rs_ent` VARCHAR(255) NULL,
  `adr_ent` VARCHAR(255) NULL,
  `cp_ent` VARCHAR(5) NULL,
  `ville_ent` VARCHAR(100) NULL,
  `tel_ent` VARCHAR(15) NULL,
  `fax_ent` VARCHAR(15) NULL,
  `email_ent` VARCHAR(100) NULL,
  `comm_ent` VARCHAR(255) NULL,
  PRIMARY KEY (`num_ent`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE ENTREPRISE
ADD CONSTRAINT FK_DOMAINE FOREIGN KEY (code_domaine) REFERENCES DOMAINE(code_domaine);


DROP TABLE IF EXISTS `ENTREPRISE_ETUD`;
CREATE TABLE `ENTREPRISE_ETUD` (
  `num_ent` INT(10) NOT NULL AUTO_INCREMENT,
  `code_domaine` VARCHAR(3) NULL,
  `rs_ent` VARCHAR(255) NULL,
  `adr_ent` VARCHAR(255) NULL,
  `cp_ent` VARCHAR(5) NULL,
  `ville_ent` VARCHAR(100) NULL,
  `tel_ent` VARCHAR(15) NULL,
  `fax_ent` VARCHAR(15) NULL,
  `email_ent` VARCHAR(100) NULL,
  `comm_ent` VARCHAR(255) NULL,
  PRIMARY KEY (`num_ent`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE ENTREPRISE_ETUD
ADD CONSTRAINT FK_EE_DOMAINE FOREIGN KEY (code_domaine) REFERENCES DOMAINE(code_domaine);

DROP TABLE IF EXISTS `OPTIONS`;
CREATE TABLE `OPTIONS` (
  `code_option` VARCHAR(2) NOT NULL,
  `lib_option` VARCHAR(50) NULL,
  PRIMARY KEY (`code_option`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `ETUDIANT`;
CREATE TABLE `ETUDIANT` (
  `num_etud` INT(10) NOT NULL AUTO_INCREMENT,
  `nom_etud` VARCHAR(50) NULL,
  `prenom_etud` VARCHAR(50) NULL,
  `datenaiss_etud` DATETIME NULL,
  `adr_etud` VARCHAR(255) NULL,
  `cp_etud` VARCHAR(5) NULL,
  `ville_etud` VARCHAR(100) NULL,
  `tel_etud` VARCHAR(15) NULL,
  `email_etud` VARCHAR(100) NULL,
  `option_etud` VARCHAR(2) NULL,
  `annee_session_etud` INT(10) NULL,
  `annee_obtention_etud` INT(10) NULL,
  `nomutil_etud` VARCHAR(30) NULL,
  `mdp_etud` VARCHAR(8) NULL,
  `confid_etud` TINYINT(1) NOT NULL,
  `url_etud` VARCHAR(255) NULL,
  `comm_etud` LONGTEXT NULL,
  `etudsup_etud` LONGTEXT NULL,
  `datecnx_etud` DATETIME NULL,
  `uagent_etud` VARCHAR(255) NULL,
  PRIMARY KEY (`num_etud`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `ETUDIANT`
ADD CONSTRAINT FK_OPTION FOREIGN KEY (option_etud) REFERENCES `OPTIONS`(code_option);

DROP TABLE IF EXISTS `TYPE_CONTRAT`;
CREATE TABLE `TYPE_CONTRAT` (
  `code_typcon` VARCHAR(3) NOT NULL,
  `lib_typcon` VARCHAR(50) NULL,
  PRIMARY KEY (`code_typcon`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `OFFRE_EMPLOI`;
CREATE TABLE `OFFRE_EMPLOI` (
  `num_offre` INT(10) NOT NULL AUTO_INCREMENT,
  `date_offre` DATETIME NULL,
  `coord_conseil_offre` VARCHAR(255) NULL,
  `num_ent` INT(10) NULL,
  `fonction_offre` VARCHAR(80) NULL,
  `formation_offre` VARCHAR(50) NULL,
  `region_offre` VARCHAR(50) NULL,
  `secteur_offre` VARCHAR(80) NULL,
  `exper_offre` VARCHAR(30) NULL,
  `age_offre` VARCHAR(20) NULL,
  `type_offre` VARCHAR(3) NULL,
  `lib_poste` VARCHAR(240) NULL,
  `descriptif_poste` LONGTEXT NULL,
  `fichier_offre` VARCHAR(50) NULL,
  PRIMARY KEY (`num_offre`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE OFFRE_EMPLOI
ADD CONSTRAINT FK_OE_ENT FOREIGN KEY (num_ent) REFERENCES ENTREPRISE(num_ent);

ALTER TABLE OFFRE_EMPLOI
ADD CONSTRAINT FK_OE_TYPECONTRAT FOREIGN KEY (type_offre) REFERENCES TYPE_CONTRAT(code_typcon);


DROP TABLE IF EXISTS `PROFESSEUR`;
CREATE TABLE `PROFESSEUR` (
  `num_prof` INT(10) NOT NULL AUTO_INCREMENT,
  `nomutil_prof` VARCHAR(10) NULL,
  `mdp_prof` VARCHAR(8) NULL,
  PRIMARY KEY (`num_prof`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `TRAVAILLE_DANS`;
CREATE TABLE `TRAVAILLE_DANS` (
  `num_etud` INT(10) NOT NULL,
  `num_ent` INT(10) NOT NULL,
  `type_trav` LONGTEXT NULL,
  `ddeb_trav` DATETIME NULL,
  `dfin_trav` DATETIME NULL,
  `poste_trav` LONGTEXT NULL,
  PRIMARY KEY (`num_etud`, `num_ent`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE TRAVAILLE_DANS
ADD CONSTRAINT FK_TD_ETUD FOREIGN KEY (num_etud) REFERENCES ETUDIANT(num_etud);

ALTER TABLE TRAVAILLE_DANS
ADD CONSTRAINT FK_TD_ENT FOREIGN KEY (num_ent) REFERENCES ENTREPRISE_ETUD(num_ent);


-- ----------------------------------------------------------------------
-- EOF
