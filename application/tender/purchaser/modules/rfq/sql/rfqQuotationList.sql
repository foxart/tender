SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`rfq`.`id` AS `rfq_id`,
			`rfq`.`purchaser_company_id` AS `purchaser_company_id`,
			`rfq_quotation`.`delivery_date` AS `rfq_quotation_delivery_date`,
			`rfq_quotation`.`delivery_cost` AS `rfq_quotation_delivery_cost`,
			`rfq_quotation`.`quantity` AS `rfq_quotation_quantity`,
			`rfq_quotation`.`tax_cost` AS `rfq_quotation_tax_cost`,
			`rfq_quotation`.`total_cost` AS `rfq_quotation_total_cost`,
			`rfq_quotation`.`unit_cost` AS `rfq_quotation_unit_cost`,
			`rfq_cross_material`.`id` AS `rfq_cross_material_id`,
			`rfq_cross_material`.`quantity` AS `rfq_cross_material_quantity`,
			`material`.`id` AS `material_id`,
			`material`.`name` AS `material_name`,
# 			`material`.`description` AS `material_description`,
# 			`material`.`po` AS `material_po`,
# 			`material_group`.`name` AS `material_group_name`,
			`material_uom`.`name` AS `material_uom_name`,
			`vendor_company`.`id` AS `vendor_company_id`,
			`vendor_company`.`name` AS `vendor_company_name`
		FROM
			`rfq`
			INNER JOIN
			`rfq_quotation`
			ON `rfq`.`id` = `rfq_quotation`.`rfq_id`
			INNER JOIN
			`rfq_cross_material`
			ON `rfq_quotation`.`rfq_cross_material_id` = `rfq_cross_material`.`id`
			INNER JOIN
			`material`
			ON `material`.`id` = `rfq_cross_material`.`material_id`
			INNER JOIN
			`material_group`
			ON `material_group`.`id` = `material`.`material_group_id`
			INNER JOIN
			`material_uom`
			ON `material_uom`.`id` = `material`.`material_uom_id`
			INNER JOIN
			`rfq_cross_vendor_company`
			ON `rfq_quotation`.`rfq_cross_vendor_company_id` = `rfq_cross_vendor_company`.`id`
			INNER JOIN
			`vendor_company`
			ON `rfq_cross_vendor_company`.`vendor_company_id` = `vendor_company`.`id`
		WHERE
			`rfq`.`id` = :rfq_id
				AND
				`rfq`.`account_id` = :account_id
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
ORDER BY
	`records`.`material_name`,
	`records`.`vendor_company_name`
