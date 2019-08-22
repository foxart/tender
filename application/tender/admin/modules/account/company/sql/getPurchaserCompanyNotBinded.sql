SELECT
	`purchaser_company`.`id` AS `id`,
	`purchaser_company`.`name` AS `text`
FROM
	`purchaser_company`
	LEFT JOIN
	`purchaser_company_cross_account`
	ON `purchaser_company`.`id` = `purchaser_company_cross_account`.`purchaser_company_id`
		AND `purchaser_company_cross_account`.`account_id` = :account_id
WHERE
	`purchaser_company`.`id` NOT IN
		(
			SELECT
				`purchaser_company_cross_account`.`purchaser_company_id`
			FROM
				`purchaser_company_cross_account`
			WHERE
				`purchaser_company_cross_account`.`account_id` =
					(
						SELECT
							`account`.`id`
						FROM
							`account`
						WHERE
							`account`.`id` = :account_id
					)
		)
		AND IF(:query_string IS NULL, 1, `purchaser_company`.`name` LIKE concat('%', :query_string, '%'))
