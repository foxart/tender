SELECT
	COUNT(DISTINCT `geo`.`country_name`) AS `count`
FROM
	`geo`
WHERE
	`geo`.`country_name` IS NOT NULL


