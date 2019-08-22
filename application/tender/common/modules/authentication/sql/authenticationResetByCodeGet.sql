SELECT
	`account`.`name` AS `account_name`,
	`authentication`.`email` AS `authentication_email`
FROM
	`account`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
WHERE
	`authentication`.`password_code` = :authentication_password_code
