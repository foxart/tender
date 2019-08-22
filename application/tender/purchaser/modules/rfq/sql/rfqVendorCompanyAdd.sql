INSERT INTO
	`rfq_cross_vendor_company`
	(
		`rfq_id`,
		`vendor_company_id`
	)
VALUES
	(
		(
			SELECT
				`rfq`.`id`
			FROM
				`rfq`
			WHERE
				`rfq`.`account_id` = :account_id
					AND
					`rfq`.`id` = :rfq_id
		),
		:company_id
	)
