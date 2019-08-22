SELECT
	`account`.`surname` AS `account_surname`,
	`account`.`name` AS `account_name`,
	`account`.`patronymic` AS `account_patronymic`
FROM
	`account`
WHERE
	`account`.`id` = :account_id
