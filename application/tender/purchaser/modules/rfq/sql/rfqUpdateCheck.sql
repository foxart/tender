SELECT
	COUNT(*) AS `count`
FROM
	`rfq`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND
		`purchaser_company_id` = :rfq_company_id
