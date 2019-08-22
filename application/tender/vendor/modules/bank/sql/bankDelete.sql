DELETE FROM
	`vendor_company_bank`
WHERE
	`vendor_company_bank`.`id` = :bank_id
		AND
		`vendor_company_bank`.`company_id` = (
			SELECT
				`vendor_company`.`id`
			FROM
				`vendor_company`
			WHERE
				`vendor_company`.`id` = :company_id
					AND
					`vendor_company`.`account_id` = :account_id
		)
