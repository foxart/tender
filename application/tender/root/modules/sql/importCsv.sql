LOAD DATA LOCAL INFILE :filename INTO TABLE `geo_import` FIELDS TERMINATED BY ','
ENCLOSED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES (
	`geoname_id`,
	`locale_code`,
	`continent_code`,
	`continent_name`,
	`country_iso_code`,
	`country_name`,
	`subdivision_1_iso_code`,
	`subdivision_1_name`,
	`subdivision_2_iso_code`,
	`subdivision_2_name`,
	`city_name`,
	`metro_code`,
	`time_zone`
)
;



