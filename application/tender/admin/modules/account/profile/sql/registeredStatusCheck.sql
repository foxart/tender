SELECT
	count(`account`.`id`) AS `count`
FROM
	`account`
	INNER JOIN
	`authentication`
	ON `account`.`authentication_id` = `authentication`.`id`
WHERE
	`account`.`id` = :account_id
		AND `authentication`.`registration_code` IS NULL
