SELECT
	COUNT(DISTINCT `geo`.`continent_name`, `geo`.`country_name`, `geo`.`subdivision_1_name`) AS `count`
FROM
	`geo`
WHERE
	`geo`.`subdivision_1_name` IS NOT NULL
