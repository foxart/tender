SELECT
	`account`.`surname` AS `account_surname`,
	`account`.`name` AS `account_name`,
	`account`.`patronymic` AS `account_patronymic`,
	`account_type`.`name` AS `account_type_name`,
	`authentication`.`email` AS `authentication_email`,
	`authorization`.`name` AS `authorization_name`
FROM
	`account`
	INNER JOIN
	`account_type`
	ON `account_type`.`id` = `account`.`account_type_id`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
	LEFT JOIN
	`authorization`
	ON `authorization`.`id` = `account`.`authorization_id`
WHERE
	`account`.`id` = :account_id
