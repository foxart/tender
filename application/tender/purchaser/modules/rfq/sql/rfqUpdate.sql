UPDATE
	`rfq`
SET
	`rfq`.`purchaser_company_id` = :rfq_company_id,
	`rfq`.`date_question` = :rfq_date_question,
	`rfq`.`date_quote` = :rfq_date_quote,
	`rfq`.`name` = :rfq_name,
	`rfq`.`remark` = :rfq_remark,
	`rfq`.`term` = :rfq_term
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
