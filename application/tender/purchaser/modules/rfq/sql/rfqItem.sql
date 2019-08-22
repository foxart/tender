SELECT
	`rfq`.`id` AS `rfq_id`,
	`rfq`.`purchaser_company_id` AS `rfq_company_id`,
	`rfq`.`status` AS `rfq_status`,
	`rfq`.`date_publish` AS `rfq_date_publish`,
	`rfq`.`date_question` AS `rfq_date_question`,
	`rfq`.`date_quote` AS `rfq_date_quote`,
	`rfq`.`name` AS `rfq_name`,
	`rfq`.`remark` AS `rfq_remark`,
	`rfq`.`term` AS `rfq_term`,
	`purchaser_company`.`name` AS `company_name`
FROM
	`rfq`
	INNER JOIN
	`purchaser_company`
	ON `purchaser_company`.`id` = `rfq`.`purchaser_company_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
