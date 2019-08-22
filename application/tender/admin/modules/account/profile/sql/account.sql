SELECT
	`account`.`id` AS `account_id`,
	`authentication`.`email` AS `authentication_email`,
	`account`.`account_type_id` AS `account_account_type_id`,
	`authentication`.`active` AS `authentication_active`,
	`account`.`surname` AS `account_surname`,
	`account`.`name` AS `account_name`,
	`account`.`patronymic` AS `account_patronymic`,
	`account_type`.`name` AS `account_type_name`,
	`authorization`.`name` AS `authorization_name`
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
