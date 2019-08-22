UPDATE
	`vendor_company_excise`
SET
	`company_excise_basis_id` = :excise_basis,
	`company_excise_tax_id` = :excise_tax,
	`registration` = :excise_registration,
	`registration_number` = :excise_registration_number,
	`sales` = :excise_sales,
	`sales_number` = :excise_sales_number,
	`service` = :excise_service,
	`service_number` = :excise_service_number,
	`license` = :excise_license
WHERE
	`vendor_company_excise`.`company_id` = (
		SELECT
			`vendor_company`.`id`
		FROM
			`vendor_company`
		WHERE
			`vendor_company`.`id` = :company_id
				AND
				`vendor_company`.`account_id` = :account_id
	)
