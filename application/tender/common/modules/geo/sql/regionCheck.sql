# SELECT
# 	`geo_region`.`id`
# FROM
# 	`geo_region`
# WHERE
# 	`geo_region`.`name` = :region
SELECT
	`geo`.`subdivision_1_name`
FROM
	`geo`
WHERE
	`geo`.`country_name` = :country
		AND
		`geo`.`subdivision_1_name` = :region
GROUP BY
	`geo`.`country_name`,
	`geo`.`subdivision_1_name`
