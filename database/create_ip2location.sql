USE geoip;
CREATE TABLE `ip2location`(
               `ip_from` DECIMAL(39,0),
               `ip_to` DECIMAL(39,0),
               `country_code` CHAR(2),
               `country_name` VARCHAR(64),
               PRIMARY KEY (`ip_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;