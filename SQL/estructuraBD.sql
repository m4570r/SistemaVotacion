/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/

-- Base de Datos: `ejemploVotoBD`
CREATE DATABASE IF NOT EXISTS ejemploVotoBD;
USE ejemploVotoBD;

-- Tabla `region_cl`
CREATE TABLE `region_cl` (
  `id_rg` int(11) NOT NULL AUTO_INCREMENT,
  `str_descripcion` varchar(30) NOT NULL,
  `str_romano` varchar(10) NOT NULL,
  `int_provincias` int(11) NOT NULL,
  `int_comunas` int(11) NOT NULL,
  PRIMARY KEY (`id_rg`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- Tabla `provincia_cl`
CREATE TABLE `provincia_cl` (
  `id_pr` int(11) NOT NULL AUTO_INCREMENT,
  `id_rg` int(11) NOT NULL,
  `str_descripcion` varchar(30) NOT NULL,
  `num_comunas` int(11) NOT NULL,
  PRIMARY KEY (`id_pr`),
  FOREIGN KEY (`id_rg`) REFERENCES `region_cl`(`id_rg`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- Tabla `comuna_cl`
CREATE TABLE `comuna_cl` (
  `id_co` int(11) NOT NULL AUTO_INCREMENT,
  `id_pr` int(11) NOT NULL,
  `str_descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`id_co`),
  FOREIGN KEY (`id_pr`) REFERENCES `provincia_cl`(`id_pr`)
) ENGINE=InnoDB AUTO_INCREMENT=347 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla `candidato`
CREATE TABLE `candidato` (
  `id_candidato` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `partido_politico` varchar(100) NOT NULL,
  `eleccion_id` int(11) NOT NULL,
  PRIMARY KEY (`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- Tabla `como_se_entero`
CREATE TABLE `como_se_entero` (
  `id_cse` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla `votar`
CREATE TABLE `votar` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `alias` VARCHAR(100) NOT NULL,
    `rut` VARCHAR(12) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL,
    `id_rg` INT NOT NULL,
    `id_co` INT NOT NULL,
    `id_candidato` INT NOT NULL,
    FOREIGN KEY (`id_rg`) REFERENCES `region_cl`(`id_rg`),
    FOREIGN KEY (`id_co`) REFERENCES `comuna_cl`(`id_co`),
    FOREIGN KEY (`id_candidato`) REFERENCES `candidato`(`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla `voto_cser`
CREATE TABLE voto_cse (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_voto INT,
  id_cse INT,
  FOREIGN KEY (id_voto) REFERENCES votar(id),
  FOREIGN KEY (id_cse) REFERENCES como_se_entero(id_cse)
);

