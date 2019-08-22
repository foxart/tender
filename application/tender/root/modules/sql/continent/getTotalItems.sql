SELECT
	COUNT(DISTINCT `geo`.`continent_name`) AS `count`
FROM
	`geo`
WHERE
	`geo`.`continent_name` IS NOT NULL


