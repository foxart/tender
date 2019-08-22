SELECT
	`name` AS `name`
FROM
	`import_geo_timezone`
WHERE
	`name` = :name
LIMIT 1

