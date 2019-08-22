# SELECT
# 	`geo_country`.`id` AS `id`,
# 	`geo_country`.`name` AS `value`
# FROM
# 	`geo_country`
# WHERE
# 	`geo_country`.`name` LIKE CONCAT('%', :geo_country, '%')
# LIMIT
# 	:limit
SELECT
	`geo`.`geoname_id` AS `id`,
	`geo`.`country_name` AS `value`
FROM
	`geo`
WHERE
	`geo`.`country_name` LIKE CONCAT('%', :geo_country, '%')
GROUP BY
	`geo`.`country_name`
LIMIT
	:limit
