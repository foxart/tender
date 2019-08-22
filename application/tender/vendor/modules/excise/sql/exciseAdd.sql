INSERT INTO
	`vendor_company_excise`
	(
		`company_id`,
		`company_excise_basis_id`,
		`company_excise_tax_id`,
		`registration`,
		`registration_number`,
		`sales`,
		`sales_number`,
		`service`,
		`service_number`,
		`license`
	)
VALUES
	(
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
		:excise_basis,
		:excise_tax,
		:excise_registration,
		:excise_registration_number,
		:excise_service,
		:excise_service_number,
		:excise_sales,
		:excise_sales_number,
		:excise_license
	)
