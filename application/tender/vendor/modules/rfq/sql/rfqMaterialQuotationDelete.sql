DELETE FROM
	`rfq_quotation`
WHERE
	`rfq_cross_material_id` = :rfq_cross_material_id
		AND
		`rfq_cross_vendor_company_id` = :rfq_cross_vendor_company_id


