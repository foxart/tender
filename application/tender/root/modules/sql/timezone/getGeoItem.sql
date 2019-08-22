SELECT
	`result`.`name` AS `name`
FROM
	(
		SELECT
			@`row` := @`row` + 1 AS `row`,
			`records`.*
		FROM
			(
				SELECT
					DISTINCT
					`geo`.`time_zone` AS `name`
				FROM
					`geo`
				WHERE
					`geo`.`time_zone` IS NOT NULL
				ORDER BY
					`geo`.`time_zone` ASC
			) AS `records`,
			(
				SELECT
					@`row` := 0
			) AS `counter`
	) AS `result`
WHERE
	`result`.`row` = :id

