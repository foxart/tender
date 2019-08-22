UPDATE
	`rfq_quotation`
SET
	`rfq_quotation`.`delivery_date` = :rfq_material_quotation_delivery_date,
	`rfq_quotation`.`delivery_cost` = :rfq_material_quotation_delivery_cost,
	`rfq_quotation`.`quantity` = :rfq_material_quotation_quantity,
	`rfq_quotation`.`tax_cost` = :rfq_material_quotation_tax_cost,
	`rfq_quotation`.`total_cost` = :rfq_material_quotation_total_cost,
	`rfq_quotation`.`unit_cost` = :rfq_material_quotation_unit_cost
WHERE
	`rfq_cross_material_id` = :rfq_cross_material_id
		AND
		`rfq_cross_vendor_company_id` = :rfq_cross_vendor_company_id
		AND
		`rfq_quotation`.`rfq_id` = :rfq_id
