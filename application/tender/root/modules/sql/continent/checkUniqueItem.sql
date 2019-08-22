SELECT
	`name` AS `name`,
	`code` AS `code`
FROM
	`import_geo_continent`
WHERE
	`name` = :name AND `code` = :code
LIMIT 1
