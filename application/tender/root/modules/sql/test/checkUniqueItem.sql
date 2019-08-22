SELECT
	`name` AS `name`,
	`code` AS `code`
FROM
	`import_geo_country`
WHERE
	`geo_continent_id` = :geo_continent_id AND
		`geo` = :geo AND
		`name` = :name
		AND `code` = :code
LIMIT 1

