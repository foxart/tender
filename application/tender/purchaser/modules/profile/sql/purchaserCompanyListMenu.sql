SELECT
	`purchaser_company_cross_vendor_company`.`purchaser_company_id` AS `purchaser_company_id`,
	`purchaser_company_cross_vendor_company`.`vendor_company_id` AS `vendor_company_id`,
	`purchaser_company`.`name` AS `purchaser_company_name`
FROM
	`purchaser_company`
	INNER JOIN
	`purchaser_company_cross_vendor_company`
	ON `purchaser_company_cross_vendor_company`.`purchaser_company_id` = `purchaser_company`.`id`
WHERE
	`purchaser_company_cross_vendor_company`.`purchaser_company_id` IN
		(
			SELECT
				`purchaser_company_cross_account`.`purchaser_company_id`
			FROM
				`purchaser_company_cross_account`
			WHERE
				`purchaser_company_cross_account`.`account_id` = :account_id
		)
GROUP BY
	`purchaser_company`.`name`
