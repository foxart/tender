INSERT INTO
	`purchaser_company_cross_account_cross_material`
	(
		`account_id`,
		`purchaser_company_id`,
		`material_id`
	)
VALUES
	(
		:account_id,
		(
			SELECT
				`purchaser_company_cross_account`.`purchaser_company_id`
			FROM
				`purchaser_company_cross_account`
			WHERE
				`purchaser_company_cross_account`.`purchaser_company_id` = :company_id
					AND
					`purchaser_company_cross_account`.`account_id` = :account_id
		),
		:material_id
	)
