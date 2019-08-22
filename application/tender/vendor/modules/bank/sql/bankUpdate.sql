UPDATE
	`vendor_company_bank`
SET
	`key` = :bank_key,
	`account` = :bank_account,
	`holder` = :bank_holder
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
