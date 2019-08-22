SELECT
	`result`.`name` AS `name`,
	`result`.`code` AS `code`
FROM
	(
		SELECT
			@`row` := @`row` + 1 AS `row`,
			`records`.*
		FROM
			(
				SELECT
					`continent_name` AS `name`,
					`continent_code` AS `code`
				FROM
					`geo`
				WHERE
					`geo`.`continent_name` IS NOT NULL
				GROUP BY
					`geo`.`continent_name`
				ORDER BY
					`geo`.`continent_name` ASC
			) AS `records`,
			(
				SELECT
					@`row` := 0
			) AS `counter`
	) AS `result`
WHERE
	`result`.`row` > :id
LIMIT 1
