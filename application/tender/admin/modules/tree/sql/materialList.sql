SELECT
	`material`.`id` AS `id`,
	`material`.`material_id` AS `parent`,
	CONCAT_WS(' || ', `material`.`name`, `material`.`description`) AS `text`,
	`material`.`material_type` AS `type`
FROM
	`material`
