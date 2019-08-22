INSERT INTO
	`vendor_company_cross_account_cross_material`
	(
		`account_id`,
		`vendor_company_id`,
		`material_id`
	)
VALUES
	(
		:account_id,
		(
			SELECT
				`vendor_company`.`id`
			FROM
				`vendor_company`
			WHERE
				`vendor_company`.`id` = :company_id
					AND
					`vendor_company`.`account_id` = :account_id
		),
		:material_id
	)
