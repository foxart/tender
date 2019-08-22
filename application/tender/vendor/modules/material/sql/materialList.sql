SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`vendor_company_cross_account_cross_material`.`title` AS `material_title`,
			`vendor_company_cross_account_cross_material`.`file` AS `material_file`,
			`material`.`id` AS `material_id`,
			`material`.`name` AS `material_name`,
			`material`.`description` AS `material_description`,
			`material`.`po` AS `material_po`,
			`material_group`.`id` AS `material_group_id`,
			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom`
		FROM
			`vendor_company_cross_account_cross_material`
			INNER JOIN
			`material`
			ON `vendor_company_cross_account_cross_material`.`material_id` = `material`.`id`
			INNER JOIN
			`material_group`
			ON `material`.`material_group_id` = `material_group`.`id`
			INNER JOIN
			`material_uom`
			ON `material`.`material_uom_id` = `material_uom`.`id`
		WHERE
			`vendor_company_cross_account_cross_material`.`account_id` = :account_id
				AND `vendor_company_cross_account_cross_material`.`vendor_company_id` =
				(
					SELECT
						`vendor_company`.`id`
					FROM
						`vendor_company`
					WHERE
						`vendor_company`.`id` = :company_id
							AND
							`vendor_company`.`account_id` = :account_id
				)
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
