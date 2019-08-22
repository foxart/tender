SELECT
	`vendor_company_excise_tax`.`id` AS `excise_tax`,
	`vendor_company_excise_basis`.`id` AS `excise_basis`,
	`vendor_company_excise`.`registration` AS `excise_registration`,
	`vendor_company_excise`.`registration_number` AS `excise_registration_number`,
	`vendor_company_excise`.`sales` AS `excise_sales`,
	`vendor_company_excise`.`sales_number` AS `excise_sales_number`,
	`vendor_company_excise`.`service` AS `excise_service`,
	`vendor_company_excise`.`service_number` AS `excise_service_number`,
	`vendor_company_excise`.`license` AS `excise_license`
FROM
	`vendor_company_excise`
	INNER JOIN
	`vendor_company_excise_tax`
	ON `vendor_company_excise_tax`.`id` = `vendor_company_excise`.`company_excise_tax_id`
	INNER JOIN
	`vendor_company_excise_basis`
	ON `vendor_company_excise_basis`.`id` = `vendor_company_excise`.`company_excise_basis_id`
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
