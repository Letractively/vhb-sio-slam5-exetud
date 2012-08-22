-- ----------------------------------------------------------------------
-- MySQL Migration Toolkit
-- SQL Create Script
-- 
-- Tables

DROP TABLE IF EXISTS `domaine`;
CREATE TABLE `domaine` (
  `code_domaine` VARCHAR(3) NOT NULL,
  `lib_domaine` VARCHAR(128) NULL,
  PRIMARY KEY (`code_domaine`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE `entreprise` (
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

ALTER TABLE entreprise
ADD CONSTRAINT fk_domaine FOREIGN KEY (code_domaine) REFERENCES domaine(code_domaine);


DROP TABLE IF EXISTS `entreprise_etud`;
CREATE TABLE `entreprise_etud` (
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

ALTER TABLE entreprise_etud
ADD CONSTRAINT fk_ee_domaine FOREIGN KEY (code_domaine) REFERENCES domaine(code_domaine);

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `code_option` VARCHAR(2) NOT NULL,
  `lib_option` VARCHAR(50) NULL,
  PRIMARY KEY (`code_option`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE `etudiant` (
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

ALTER TABLE `etudiant`
ADD CONSTRAINT fk_options FOREIGN KEY (option_etud) REFERENCES `options`(code_option);

DROP TABLE IF EXISTS `type_contrat`;
CREATE TABLE `type_contrat` (
  `code_typcon` VARCHAR(3) NOT NULL,
  `lib_typcon` VARCHAR(50) NULL,
  PRIMARY KEY (`code_typcon`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `offre_emploi`;
CREATE TABLE `offre_emploi` (
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

ALTER TABLE offre_emploi
ADD CONSTRAINT fk_oe_ent FOREIGN KEY (num_ent) REFERENCES entreprise(num_ent);

ALTER TABLE offre_emploi
ADD CONSTRAINT fk_oe_typecontrat FOREIGN KEY (type_offre) REFERENCES type_contrat(code_typcon);


DROP TABLE IF EXISTS `professeur`;
CREATE TABLE `professeur` (
  `num_prof` INT(10) NOT NULL AUTO_INCREMENT,
  `nomutil_prof` VARCHAR(10) NULL,
  `mdp_prof` VARCHAR(8) NULL,
  PRIMARY KEY (`num_prof`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `travaille_dans`;
CREATE TABLE `travaille_dans` (
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

ALTER TABLE travaille_dans
ADD CONSTRAINT fk_td_etud FOREIGN KEY (num_etud) REFERENCES etudiant(num_etud);

ALTER TABLE travaille_dans
ADD CONSTRAINT fk_td_ent FOREIGN KEY (num_ent) REFERENCES entreprise_etud(num_ent);


-- ----------------------------------------------------------------------
-- EOF
