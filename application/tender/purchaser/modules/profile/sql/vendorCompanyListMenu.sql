SELECT
	`purchaser_company_cross_vendor_company`.`purchaser_company_id` AS `purchaser_company_id`,
	`vendor_company`.`id` AS `vendor_company_id`,
	`vendor_company`.`name` AS `vendor_company_name`
FROM
	`purchaser_company_cross_vendor_company`
	INNER JOIN
	`vendor_company` AS `vendor_company`
	ON `purchaser_company_cross_vendor_company`.`vendor_company_id` = `vendor_company`.`id`
	INNER JOIN
	`purchaser_company_cross_account`
	ON `purchaser_company_cross_account`.`purchaser_company_id` = `purchaser_company_cross_vendor_company`.`purchaser_company_id`
WHERE
	`purchaser_company_cross_vendor_company`.`purchaser_company_id` = :purchaser_company_id
		AND
		`purchaser_company_cross_account`.`account_id` = :account_id

# 		AND
# 		`purchaser_company_cross_vendor_company`.`purchaser_company_id` IN (
# 			SELECT
# 				`purchaser_company_cross_account`.`purchaser_company_id`
# 			FROM
# 				`purchaser_company_cross_account`
# 			WHERE
# 				`purchaser_company_cross_account`.`account_id` = :account_id
# 		)
