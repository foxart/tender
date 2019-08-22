SELECT
	`account`.`name` AS `account_name`,
	`authentication`.`email` AS `authentication_email`,
	`account_type`.`name` AS `account_type_name`
FROM
	`account`
	INNER JOIN
	`account_type`
	ON `account`.`account_type_id` = `account_type`.`id`
	INNER JOIN
	`authentication`
	ON `account`.`authentication_id` = `authentication`.`id`
	LEFT JOIN
	`authorization`
	ON `authorization`.`id` = `account`.`authorization_id`
WHERE
	`account`.`id` = :account_id
ORDER BY
	`authentication`.`id` DESC
