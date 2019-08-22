SELECT
	`rfq_quotation`.`delivery_date` AS `rfq_material_quotation_delivery_date`,
	`rfq_quotation`.`delivery_cost` AS `rfq_material_quotation_delivery_cost`,
	`rfq_quotation`.`quantity` AS `rfq_material_quotation_quantity`,
	`rfq_quotation`.`tax_cost` AS `rfq_material_quotation_tax_cost`,
	`rfq_quotation`.`total_cost` AS `rfq_material_quotation_total_cost`,
	`rfq_quotation`.`unit_cost` AS `rfq_material_quotation_unit_cost`
FROM
	`rfq_quotation`
WHERE
	`rfq_cross_material_id` = :rfq_cross_material_id
		AND
		`rfq_cross_vendor_company_id` = :rfq_cross_vendor_company_id
