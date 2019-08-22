SELECT
	`material`.`name` AS `material_group_name`
FROM
	`material`
WHERE
	`material`.`id` = :material_group_id
