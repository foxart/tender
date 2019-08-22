SELECT
	`account_type`.`id` AS `account_type_id`,
	`account_type`.`name` AS `account_type_name`
FROM
	`account`
	INNER JOIN
	`account_type`
	ON `account`.`account_type_id` = `account_type`.`id`
WHERE
	`account`.`id` = :account_id
