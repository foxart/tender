SELECT
	COUNT(*) AS `count`
FROM
	`material`
WHERE
	`name` = :material_name
		AND
		`id` != :material_id

