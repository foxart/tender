SELECT
	`account_type`.`id` AS `account_type_id`
FROM
	`account_type`
WHERE
	`account_type`.`name` = :account_type_name
