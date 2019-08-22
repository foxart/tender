DELETE
	`account`,
	`authentication`
FROM
	`account`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
WHERE
	`account`.`id` = :account_id
