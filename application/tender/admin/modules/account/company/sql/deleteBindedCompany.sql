DELETE FROM
	`purchaser_company_cross_account`
WHERE
	`purchaser_company_cross_account`.`account_id` = :account_id
		AND
		`purchaser_company_cross_account`.`purchaser_company_id` = :company_id
