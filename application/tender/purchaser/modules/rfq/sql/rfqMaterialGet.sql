SELECT
	`material`.`name` AS `material_name`,
	`rfq_cross_material`.`quantity` AS `rfq_material_quantity`
FROM
	`rfq_cross_material`
	INNER JOIN
	`rfq`
	ON `rfq`.`id` = `rfq_cross_material`.`rfq_id`
	INNER JOIN
	`material`
	ON `material`.`id` = `rfq_cross_material`.`material_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND `rfq_cross_material`.`material_id` = :material_id
