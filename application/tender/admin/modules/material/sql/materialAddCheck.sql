SELECT
	count(*) AS `count`
FROM
	`material`
WHERE
	`name` = :material_name
