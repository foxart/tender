SELECT
	COUNT(DISTINCT `geo`.`time_zone`) AS `count`
FROM
	`geo`
WHERE
	`geo`.`time_zone` IS NOT NULL
