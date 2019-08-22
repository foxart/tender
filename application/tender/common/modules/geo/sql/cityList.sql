# SELECT
# 	`geo_city`.`id` AS `id`
# 	,
# 	`geo_city`.`name` AS `value`
# FROM
# 	`geo_city`
# 	INNER JOIN
# 	`geo_region`
# 	ON `geo_region`.`id` = `geo_city`.`geo_region_id`
# 	INNER JOIN
# 	`geo_country`
# 	ON `geo_country`.`id` = `geo_city`.`geo_country_id`
# WHERE
# 	`geo_region`.`name` = :geo_region
# 		AND
# 		`geo_country`.`name` = :geo_country
# 		AND
# 		`geo_city`.`name` LIKE CONCAT('%', :geo_city, '%')
# LIMIT
# 	:limit
SELECT
	`geo`.`geoname_id` AS `id`
	,
	`geo`.`city_name` AS `value`
FROM
	`geo`
WHERE
	`geo`.`country_name` = :geo_country
		AND
		`geo`.`subdivision_1_name` = :geo_region
		AND
		`geo`.`city_name` LIKE CONCAT('%', :geo_city, '%')
GROUP BY
	`geo`.`country_name`,
	`geo`.`subdivision_1_name`,
	`geo`.`city_name`
LIMIT
	:limit
