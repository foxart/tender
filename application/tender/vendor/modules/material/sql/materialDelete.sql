DELETE FROM
	`vendor_company_cross_account_cross_material`
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
		AND `vendor_company_cross_account_cross_material`.`material_id` = :material_id
