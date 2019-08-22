SELECT
	*
FROM
	`material_group`
WHERE
	`name` = :material_group_name
		AND `id` != :material_group_id
