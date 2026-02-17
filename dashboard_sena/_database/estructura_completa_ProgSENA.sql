-- Base de Datos ProgSENA - Estructura Completa
-- Basada en el diagrama proporcionado

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS `progsena` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `progsena`;

-- -----------------------------------------------------
-- Tabla TITULO_PROGRAMA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TITULO_PROGRAMA` (
  `titpro_id` INT NOT NULL AUTO_INCREMENT,
  `titpro_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`titpro_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla PROGRAMA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROGRAMA` (
  `prog_codigo` INT NOT NULL AUTO_INCREMENT,
  `prog_denominacion` VARCHAR(100) NOT NULL,
  `TIT_PROGRAMA_titpro_id` INT NOT NULL,
  `prog_tipo` VARCHAR(50) NULL,
  PRIMARY KEY (`prog_codigo`),
  INDEX `fk_PROGRAMA_TITULO_PROGRAMA_idx` (`TIT_PROGRAMA_titpro_id` ASC),
  CONSTRAINT `fk_PROGRAMA_TITULO_PROGRAMA`
    FOREIGN KEY (`TIT_PROGRAMA_titpro_id`)
    REFERENCES `TITULO_PROGRAMA` (`titpro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla COMPETENCIA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COMPETENCIA` (
  `comp_id` INT NOT NULL AUTO_INCREMENT,
  `comp_nombre_corto` VARCHAR(30) NOT NULL,
  `comp_horas` INT NULL,
  `comp_nombre_unidad_competencia` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla COMPETxPROGRAMA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COMPETxPROGRAMA` (
  `PROGRAMA_prog_id` INT NOT NULL,
  `COMPETENCIA_comp_id` INT NOT NULL,
  PRIMARY KEY (`PROGRAMA_prog_id`, `COMPETENCIA_comp_id`),
  INDEX `fk_COMPETxPROGRAMA_COMPETENCIA_idx` (`COMPETENCIA_comp_id` ASC),
  CONSTRAINT `fk_COMPETxPROGRAMA_PROGRAMA`
    FOREIGN KEY (`PROGRAMA_prog_id`)
    REFERENCES `PROGRAMA` (`prog_codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_COMPETxPROGRAMA_COMPETENCIA`
    FOREIGN KEY (`COMPETENCIA_comp_id`)
    REFERENCES `COMPETENCIA` (`comp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla CENTRO_FORMACION
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CENTRO_FORMACION` (
  `cent_id` INT NOT NULL AUTO_INCREMENT,
  `cent_nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cent_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla INSTRUCTOR
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `INSTRUCTOR` (
  `inst_id` INT NOT NULL AUTO_INCREMENT,
  `inst_nombres` VARCHAR(45) NOT NULL,
  `inst_apellidos` VARCHAR(45) NOT NULL,
  `inst_correo` VARCHAR(45) NOT NULL,
  `inst_telefono` BIGINT(10) NOT NULL,
  `CENTRO_FORMACION_cent_id` INT NOT NULL,
  `inst_password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`inst_id`),
  INDEX `fk_INSTRUCTOR_CENTRO_FORMACION_idx` (`CENTRO_FORMACION_cent_id` ASC),
  CONSTRAINT `fk_INSTRUCTOR_CENTRO_FORMACION`
    FOREIGN KEY (`CENTRO_FORMACION_cent_id`)
    REFERENCES `CENTRO_FORMACION` (`cent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla INSTRU_COMPETENCIA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `INSTRU_COMPETENCIA` (
  `inscomp_id` INT NOT NULL AUTO_INCREMENT,
  `INSTRUCTOR_inst_id` INT NOT NULL,
  `COMPETxPROGRAMA_PROGRAMA_prog_id` INT NOT NULL,
  `COMPETxPROGRAMA_COMPETENCIA_comp_id` INT NOT NULL,
  `inscomp_vigencia` DATE NOT NULL,
  PRIMARY KEY (`inscomp_id`),
  INDEX `fk_INSTRU_COMPETENCIA_INSTRUCTOR_idx` (`INSTRUCTOR_inst_id` ASC),
  INDEX `fk_INSTRU_COMPETENCIA_COMPETxPROGRAMA_idx` (`COMPETxPROGRAMA_PROGRAMA_prog_id` ASC, `COMPETxPROGRAMA_COMPETENCIA_comp_id` ASC),
  CONSTRAINT `fk_INSTRU_COMPETENCIA_INSTRUCTOR`
    FOREIGN KEY (`INSTRUCTOR_inst_id`)
    REFERENCES `INSTRUCTOR` (`inst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INSTRU_COMPETENCIA_COMPETxPROGRAMA`
    FOREIGN KEY (`COMPETxPROGRAMA_PROGRAMA_prog_id` , `COMPETxPROGRAMA_COMPETENCIA_comp_id`)
    REFERENCES `COMPETxPROGRAMA` (`PROGRAMA_prog_id` , `COMPETENCIA_comp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla COORDINACION
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `COORDINACION` (
  `coord_id` INT NOT NULL AUTO_INCREMENT,
  `coord_descripcion` VARCHAR(45) NOT NULL,
  `CENTRO_FORMACION_cent_id` INT NOT NULL,
  `coord_nombre_coordinador` VARCHAR(45) NOT NULL,
  `coord_correo` VARCHAR(45) NOT NULL,
  `coord_password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`coord_id`),
  INDEX `fk_COORDINACION_CENTRO_FORMACION_idx` (`CENTRO_FORMACION_cent_id` ASC),
  CONSTRAINT `fk_COORDINACION_CENTRO_FORMACION`
    FOREIGN KEY (`CENTRO_FORMACION_cent_id`)
    REFERENCES `CENTRO_FORMACION` (`cent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla FICHA
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FICHA` (
  `fich_id` INT NOT NULL AUTO_INCREMENT,
  `PROGRAMA_prog_id` INT NOT NULL,
  `INSTRUCTOR_inst_id_lider` INT NOT NULL,
  `fich_jornada` VARCHAR(20) NOT NULL,
  `COORDINACION_coord_id` INT NOT NULL,
  `fich_fecha_ini_lectiva` DATE NOT NULL,
  `fich_fecha_fin_lectiva` DATE NOT NULL,
  PRIMARY KEY (`fich_id`),
  INDEX `fk_FICHA_PROGRAMA_idx` (`PROGRAMA_prog_id` ASC),
  INDEX `fk_FICHA_INSTRUCTOR_idx` (`INSTRUCTOR_inst_id_lider` ASC),
  INDEX `fk_FICHA_COORDINACION_idx` (`COORDINACION_coord_id` ASC),
  CONSTRAINT `fk_FICHA_PROGRAMA`
    FOREIGN KEY (`PROGRAMA_prog_id`)
    REFERENCES `PROGRAMA` (`prog_codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FICHA_INSTRUCTOR`
    FOREIGN KEY (`INSTRUCTOR_inst_id_lider`)
    REFERENCES `INSTRUCTOR` (`inst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FICHA_COORDINACION`
    FOREIGN KEY (`COORDINACION_coord_id`)
    REFERENCES `COORDINACION` (`coord_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla SEDE
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SEDE` (
  `sede_id` INT NOT NULL AUTO_INCREMENT,
  `sede_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`sede_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla ADMINISTRADOR
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ADMINISTRADOR` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `admin_nombre` VARCHAR(100) NOT NULL,
  `admin_correo` VARCHAR(100) NOT NULL UNIQUE,
  `admin_password` VARCHAR(255) NOT NULL,
  `admin_estado` ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
  `admin_ultimo_acceso` DATETIME NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar administrador por defecto
INSERT INTO `ADMINISTRADOR` (`admin_nombre`, `admin_correo`, `admin_password`, `admin_estado`) 
VALUES ('Administrador SENA', 'admin@sena.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Activo');
-- Password: password

-- -----------------------------------------------------
-- Tabla AMBIENTE
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AMBIENTE` (
  `amb_id` VARCHAR(5) NOT NULL,
  `amb_nombre` VARCHAR(45) NOT NULL,
  `SEDE_sede_id` INT NOT NULL,
  PRIMARY KEY (`amb_id`),
  INDEX `fk_AMBIENTE_SEDE_idx` (`SEDE_sede_id` ASC),
  CONSTRAINT `fk_AMBIENTE_SEDE`
    FOREIGN KEY (`SEDE_sede_id`)
    REFERENCES `SEDE` (`sede_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla ASIGNACION
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ASIGNACION` (
  `ASIG_ID` INT NOT NULL AUTO_INCREMENT,
  `INSTRUCTOR_inst_id` INT NOT NULL,
  `asig_fecha_ini` DATETIME NOT NULL,
  `asig_fecha_fin` DATETIME NOT NULL,
  `FICHA_fich_id` INT NOT NULL,
  `AMBIENTE_amb_id` VARCHAR(5) NOT NULL,
  `COMPETENCIA_comp_id` INT NOT NULL,
  PRIMARY KEY (`ASIG_ID`),
  INDEX `fk_ASIGNACION_INSTRUCTOR_idx` (`INSTRUCTOR_inst_id` ASC),
  INDEX `fk_ASIGNACION_FICHA_idx` (`FICHA_fich_id` ASC),
  INDEX `fk_ASIGNACION_AMBIENTE_idx` (`AMBIENTE_amb_id` ASC),
  INDEX `fk_ASIGNACION_COMPETENCIA_idx` (`COMPETENCIA_comp_id` ASC),
  CONSTRAINT `fk_ASIGNACION_INSTRUCTOR`
    FOREIGN KEY (`INSTRUCTOR_inst_id`)
    REFERENCES `INSTRUCTOR` (`inst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ASIGNACION_FICHA`
    FOREIGN KEY (`FICHA_fich_id`)
    REFERENCES `FICHA` (`fich_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ASIGNACION_AMBIENTE`
    FOREIGN KEY (`AMBIENTE_amb_id`)
    REFERENCES `AMBIENTE` (`amb_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ASIGNACION_COMPETENCIA`
    FOREIGN KEY (`COMPETENCIA_comp_id`)
    REFERENCES `COMPETENCIA` (`comp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Tabla DETALLExASIGNACION
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DETALLExASIGNACION` (
  `detasig_id` INT NOT NULL AUTO_INCREMENT,
  `ASIGNACION_ASIG_ID` INT NOT NULL,
  `detasig_hora_ini` DATETIME NOT NULL,
  `detasig_hora_fin` DATETIME NOT NULL,
  PRIMARY KEY (`detasig_id`),
  INDEX `fk_DETALLExASIGNACION_ASIGNACION_idx` (`ASIGNACION_ASIG_ID` ASC),
  CONSTRAINT `fk_DETALLExASIGNACION_ASIGNACION`
    FOREIGN KEY (`ASIGNACION_ASIG_ID`)
    REFERENCES `ASIGNACION` (`ASIG_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
