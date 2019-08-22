# --------------------------------- continent ID -------------------------------------------------------------
UPDATE
		`import_geo`
		INNER JOIN
		(
			SELECT
				@`row` := @`row` + 1 AS `row`,
				`records`.*
			FROM
				(
					SELECT
						DISTINCT
						`continent_name`
					FROM
						`import_geo`) AS `records`,
				(
					SELECT
						@`row` := 0) AS `counter`
			ORDER BY
				`continent_name` ASC
		) AS `result`
		ON `import_geo`.`continent_name` = `result`.`continent_name`
SET `geo_continent` = `result`.`row`

# --------------------------------- country ID -------------------------------------------------------------
UPDATE
		`import_geo`
		INNER JOIN
		(
			SELECT
				@`row` := @`row` + 1 AS `row`,
				`records`.*
			FROM
				(
					SELECT
						`continent_name`,
						`country_name`
					FROM
						`import_geo`) AS `records`,
				(
					SELECT
						@`row` := 0) AS `counter`
			WHERE
				`country_name` <> ''
			GROUP BY
				`continent_name`,
				`country_name`
			ORDER BY
				`continent_name` ASC,
				`country_name` ASC
		) AS `result`
		ON `import_geo`.`continent_name` = `result`.`continent_name` AND `import_geo`.`country_name` = `result`.`country_name`
SET `geo_country` = `result`.`row`

# --------------------------------- region ID -------------------------------------------------------------


