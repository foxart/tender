SELECT
	`name` AS `name`,
	`code` AS `code`
FROM
	`import_geo_region`
WHERE
	`geo_continent_id` = :geo_continent_id AND
		`geo_country_id` = :geo_country_id AND
		`code` = :code AND
		`name` = :name
LIMIT 1

