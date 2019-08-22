SELECT
	`result`.`geo_continent_id` AS `geo_continent_id`,
	`result`.`geo` AS `geo`,
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
					`geo`.`country_name` AS `name`,
					`geo`.`country_iso_code` AS `code`,
					`geo`.`geoname_id` AS `geo`,
					`continent`.`id` AS `geo_continent_id`
				FROM
					`geo`
					LEFT JOIN
					`import_geo_continent` AS `continent`
					ON `continent`.`code` = `geo`.`continent_code`
				WHERE
					`geo`.`country_name` IS NOT NULL
				GROUP BY
					`geo`.`country_name`
				ORDER BY
					`continent`.`id`,
					`geo`.`country_name` ASC
			) AS `records`,
			(
				SELECT
					@`row` := 0
			) AS `counter`
	) AS `result`
WHERE
	`result`.`row` = :id

