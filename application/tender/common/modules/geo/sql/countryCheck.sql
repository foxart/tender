# SELECT
# 	`geo_country`.`id`
# FROM
# 	`geo_country`
# WHERE
# 	`geo_country`.`name` = :country
SELECT
	`geo`.`country_name`
FROM
	`geo`
WHERE
	`geo`.`country_name` = :country
GROUP BY
	`geo`.`country_name`
