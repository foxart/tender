SELECT
	`purchaser_company`.`name` AS `legal_name`
FROM
	`purchaser_company`
	INNER JOIN
	`purchaser_company_cross_vendor_company`
	ON `purchaser_company_cross_vendor_company`.`purchaser_company_id` = `purchaser_company`.`id`
WHERE
	`purchaser_company_cross_vendor_company`.`purchaser_company_id` = :legal_id
		AND `purchaser_company_cross_vendor_company`.`vendor_company_id` = (
		SELECT
			`vendor_company`.`id`
		FROM
			`vendor_company`
		WHERE
			`vendor_company`.`id` = :company_id
				AND `vendor_company`.`account_id` = :account_id
	)
