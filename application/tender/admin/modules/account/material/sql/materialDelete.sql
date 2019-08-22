DELETE FROM
	`purchaser_company_cross_account_cross_material`
WHERE
	`purchaser_company_cross_account_cross_material`.`account_id` = :account_id
		AND `purchaser_company_cross_account_cross_material`.`purchaser_company_id` = (
		SELECT
			`purchaser_company_cross_account`.`purchaser_company_id`
		FROM
			`purchaser_company_cross_account`
		WHERE
			`purchaser_company_cross_account`.`purchaser_company_id` = :company_id
				AND `purchaser_company_cross_account`.`account_id` = :account_id
	)
		AND `purchaser_company_cross_account_cross_material`.`material_id` = :material_id
