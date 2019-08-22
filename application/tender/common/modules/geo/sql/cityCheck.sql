# SELECT
# 	`geo_city`.`id`
# FROM
# 	`geo_city`
# WHERE
# 	`geo_city`.`name` = :city
SELECT
	`geo`.`city_name`
FROM
	`geo`
WHERE
	`geo`.`country_name` = :country
		AND
		`geo`.`subdivision_1_name` = :region
		AND
		`geo`.`city_name` = :city
GROUP BY
	`geo`.`country_name`,
	`geo`.`subdivision_1_name`,
	`geo`.`city_name`
