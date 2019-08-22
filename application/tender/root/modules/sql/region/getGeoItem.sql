SELECT
	`result`.`geo_continent_id` AS `geo_continent_id`,
	`result`.`geo_country_id` AS `geo_country_id`,
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
					`import_geo_continent`.`id` AS `geo_continent_id`,
					`import_geo_country`.`id` AS `geo_country_id`,
					`geo`.`subdivision_1_iso_code` AS `code`,
					`geo`.`subdivision_1_name` AS `name`
				FROM
					`geo`
					INNER JOIN
					`import_geo_continent`
					ON `import_geo_continent`.`code` = `geo`.`continent_code`
					INNER JOIN
					`import_geo_country`
					ON `import_geo_country`.`code` = `geo`.`country_iso_code`
				WHERE
					`geo`.`subdivision_1_name` IS NOT NULL
				GROUP BY
					`import_geo_continent`.`id`,
					`import_geo_country`.`id`,
					`geo`.`subdivision_1_name`
				ORDER BY
					`import_geo_continent`.`id`,
					`import_geo_country`.`id`,
					`geo`.`subdivision_1_name` ASC
			) AS `records`,
			(
				SELECT
					@`row` := 0
			) AS `counter`
	) AS `result`
WHERE
	`result`.`row` = :id

