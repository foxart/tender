SELECT
	`purchaser_company`.`id`,
	`purchaser_company`.`name`
FROM
	`purchaser_company`
WHERE
	`purchaser_company`.`id` IN (
		SELECT
			`purchaser_company_cross_account`.`purchaser_company_id`
		FROM
			`purchaser_company_cross_account`
		WHERE
			`purchaser_company_cross_account`.`account_id` = :account_id
	)
