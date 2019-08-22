SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			DISTINCT
			`vendor_company_cross_account_cross_material`.`title` AS `material_title`,
			`vendor_company_cross_account_cross_material`.`file` AS `material_file`,
			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom`,
			`material`.`id` AS `material_id`,
			`material`.`name` AS `material_name`,
			`material`.`description` AS `material_description`,
			`material`.`po` AS `material_po`
		FROM
			`purchaser_company_cross_vendor_company`
			INNER JOIN
			`purchaser_company_cross_account`
			ON `purchaser_company_cross_vendor_company`.`purchaser_company_id` = `purchaser_company_cross_account`.`purchaser_company_id`
			INNER JOIN
			`vendor_company_cross_account_cross_material`
			ON `vendor_company_cross_account_cross_material`.`vendor_company_id` = `purchaser_company_cross_vendor_company`.`vendor_company_id`
			INNER JOIN
			`material`
			ON `material`.`id` = `vendor_company_cross_account_cross_material`.`material_id`
			INNER JOIN
			`material_uom`
			ON `material_uom`.`id` = `material`.`material_uom_id`
			INNER JOIN
			`material_group`
			ON `material_group`.`id` = `material`.`material_group_id`
		WHERE
			`purchaser_company_cross_vendor_company`.`vendor_company_id` = :company_id
				AND
				`purchaser_company_cross_account`.`account_id` = :account_id
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
