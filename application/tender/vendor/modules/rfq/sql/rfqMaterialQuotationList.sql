SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`rfq`.`id` AS `rfq_id`,
			`rfq_cross_material`.`id` AS `rfq_cross_material_id`,
			`rfq_cross_material`.`quantity` AS `rfq_material_quantity`,
			`rfq_cross_vendor_company`.`id` AS `rfq_cross_vendor_company_id`,
			`rfq_quotation`.`id` AS `rfq_material_quotation_id`,
			`rfq_quotation`.`delivery_date` AS `rfq_material_quotation_delivery_date`,
			`rfq_quotation`.`delivery_cost` AS `rfq_material_quotation_delivery_cost`,
			`rfq_quotation`.`quantity` AS `rfq_material_quotation_quantity`,
			`rfq_quotation`.`tax_cost` AS `rfq_material_quotation_tax_cost`,
			`rfq_quotation`.`total_cost` AS `rfq_material_quotation_total_cost`,
			`rfq_quotation`.`unit_cost` AS `rfq_material_quotation_unit_cost`,
			`vendor_company`.`id` AS `vendor_company_id`,
			`vendor_company`.`name` AS `vendor_company_name`,
			`material`.`name` AS `material_name`,
			`material`.`description` AS `material_description`,
			`material`.`po` AS `material_po`,
			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom_name`
		FROM
			`rfq`
			INNER JOIN
			`rfq_cross_vendor_company`
			ON `rfq_cross_vendor_company`.`rfq_id` = `rfq`.`id`
			INNER JOIN
			`rfq_cross_material`
			ON `rfq_cross_material`.`rfq_id` = `rfq_cross_vendor_company`.`rfq_id`
			INNER JOIN
			`vendor_company`
			ON `vendor_company`.`id` = `rfq_cross_vendor_company`.`vendor_company_id`
			INNER JOIN
			`material`
			ON `material`.`id` = `rfq_cross_material`.`material_id`
			INNER JOIN
			`material_group`
			ON `material_group`.`id` = `material`.`material_group_id`
			INNER JOIN
			`material_uom`
			ON `material_uom`.`id` = `material`.`material_uom_id`
			LEFT JOIN
			`rfq_quotation`
			ON `rfq_quotation`.`rfq_id` = `rfq`.`id`
				AND `rfq_quotation`.`rfq_cross_material_id` = `rfq_cross_material`.`id`
				AND `rfq_quotation`.`rfq_cross_vendor_company_id` = `rfq_cross_vendor_company`.`id`
		WHERE
			`rfq`.`id` = :rfq_id
				AND
				`rfq_cross_vendor_company`.`vendor_company_id` IN (
					SELECT
						`vendor_company`.`id`
					FROM
						`vendor_company`
					WHERE
						`vendor_company`.`account_id` = :account_id
				)
				AND IF(:vendor_company_id IS NULL, 1, `rfq_cross_vendor_company`.`vendor_company_id` = :vendor_company_id)
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
ORDER BY
	`records`.`vendor_company_name` ASC,
	`records`.`material_name` ASC
