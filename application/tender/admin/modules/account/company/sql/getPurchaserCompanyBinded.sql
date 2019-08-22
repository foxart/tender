SELECT
	`purchaser_company_cross_account`.`id` AS `id`,
	`purchaser_company`.`id` AS `company_id`,
	`purchaser_company`.`name` AS `text`
# 	*
FROM
	`purchaser_company_cross_account`
	INNER JOIN
	`purchaser_company`
	ON `purchaser_company`.`id` = `purchaser_company_cross_account`.`purchaser_company_id`
WHERE
	`purchaser_company_cross_account`.`account_id` = :account_id

