INSERT INTO
	`vendor_company_bank`
	(
		`company_id`,
		`key`,
		`account`,
		`holder`
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
		:bank_key,
		:bank_account,
		:bank_holder
	)
