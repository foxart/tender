SELECT
# 	`material`.`id` AS `material_id`,
	`material`.`material_group_id` AS `material_group_id`,
	`material`.`material_uom_id` AS `material_uom_id`,
	`material`.`name` AS `material_name`,
	`material`.`description` AS `material_description`,
	`material`.`po` AS `material_po`
FROM
	`material`
WHERE
	`material`.`id` = :material_id
