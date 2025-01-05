-- Création de la base de données
CREATE DATABASE IF NOT EXISTS geoip;
USE geoip;

CREATE USER IF NOT EXISTS 'geoip'@'localhost' IDENTIFIED BY 'G301P';
GRANT ALL PRIVILEGES ON geoip.* TO 'geoip'@'localhost';
CREATE USER IF NOT EXISTS 'geoip'@'%' IDENTIFIED BY 'G301P';
GRANT ALL PRIVILEGES ON geoip.* TO 'geoip'@'%';
FLUSH PRIVILEGES;
