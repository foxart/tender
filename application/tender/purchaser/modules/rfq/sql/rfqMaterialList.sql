SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`rfq`.`id` AS `rfq_id`,
			`rfq_cross_material`.`id` AS `rfq_material_id`,
			`rfq_cross_material`.`quantity` AS `rfq_material_quantity`,
			`material`.`id` AS `material_id`,
			`material`.`name` AS `material_name`,
			`material`.`description` AS `material_description`,
			`material`.`po` AS `material_po`,
			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom_name`
		FROM
			`rfq_cross_material`
			INNER JOIN
			`rfq`
			ON `rfq`.`id` = `rfq_cross_material`.`rfq_id`
			INNER JOIN
			`material`
			ON `material`.`id` = `rfq_cross_material`.`material_id`
			INNER JOIN
			`material_group`
			ON `material_group`.`id` = `material`.`material_group_id`
			INNER JOIN
			`material_uom`
			ON `material_uom`.`id` = `material`.`material_uom_id`
		WHERE
			`rfq`.`id` = :rfq_id
				AND
				`rfq`.`account_id` = :account_id
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
