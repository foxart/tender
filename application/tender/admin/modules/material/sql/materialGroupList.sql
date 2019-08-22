SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`material_group`.`id`,
			`material_group`.`material_group_id`,
			`material_group`.`name`,
			`parent`.`name` AS `parent`
		FROM
			`material_group`
			LEFT JOIN
			`material_group` AS `parent`
			ON `parent`.`id` = `material_group`.`material_group_id`
		WHERE
			IF(:material_group_name IS NULL, 1,
			   `material_group`.`name` LIKE CONCAT(
				   '%', :material_group_name, '%'
			   )
			)
		ORDER BY
			`material_group`.`id`
		DESC
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
