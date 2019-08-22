SELECT
# 	`material_group`.`id` AS `material_group_id`,
# 	`material_group`.`material_group_id` AS `material_group_parent_id`,
	`material_group`.`name` AS `material_group_name`
FROM
	`material_group`
WHERE
	`material_group`.`id` = :material_group_id
