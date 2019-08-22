SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`material`.`id` AS `material_id`,
			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom`,
			`material`.`name` AS `material_name`,
			`material`.`description` AS `material_description`,
			`material`.`po` AS `material_po`
		FROM
			`material`
			INNER JOIN
			`material_group`
			ON `material_group`.`id` = `material`.`material_group_id`
			INNER JOIN
			`material_uom`
			ON `material_uom`.`id` = `material`.`material_uom_id`
		WHERE
			IF(:material_name IS NULL, 1,
			   `material`.`name` LIKE CONCAT(
				   '%', :material_name, '%'
			   )
			)
		ORDER BY
			`material`.`id`
		DESC
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
