DELETE FROM
	`rfq`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
