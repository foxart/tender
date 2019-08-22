SELECT
	`account`.`id` AS `account_id`
FROM
	`account`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
WHERE
	`authentication`.`email` = :authentication_email
