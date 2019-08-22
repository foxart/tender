# SELECT
# 	`geo_region`.`id` AS `id`,
# 	`geo_region`.`name` AS `value`
# FROM
# 	`geo_country`
# 	INNER JOIN
# 	`geo_region`
# 	ON `geo_region`.`geo_country_id` = `geo_country`.`id`
# WHERE
# 	`geo_country`.`name` = :geo_country
# 		AND
# 		`geo_region`.`name` LIKE CONCAT('%', :geo_region, '%')
# LIMIT
# 	:limit
SELECT
	`geo`.`geoname_id` AS `id`,
	`geo`.`subdivision_1_name` AS `value`
FROM
	`geo`
WHERE
	`geo`.`country_name` = :geo_country
		AND
		`geo`.`subdivision_1_name` LIKE CONCAT('%', :geo_region, '%')
GROUP BY
	`geo`.`country_name`,
	`geo`.`subdivision_1_name`
LIMIT
	:limit
