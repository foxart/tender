UPDATE
	`account`
SET
	`account`.`surname` = :account_surname,
	`account`.`name` = :account_name,
	`account`.`patronymic` = :account_patronymic
WHERE
	`account`.`id` = :account_id

