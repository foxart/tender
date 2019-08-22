UPDATE
		`authentication`
		INNER JOIN
		`account`
		ON `authentication`.`id` = `account`.`authentication_id`
SET
	`authentication`.`active` = :authentication_active
WHERE
	`account`.`id` = :account_id


