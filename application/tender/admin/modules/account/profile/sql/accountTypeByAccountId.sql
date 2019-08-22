SELECT
	`account_type`.`name` AS `account_type_name`
FROM
	`account`
	INNER JOIN
	`account_type`
	ON `account_type`.`id` = `account`.`account_type_id`
WHERE
	`account`.`id` = :account_id
