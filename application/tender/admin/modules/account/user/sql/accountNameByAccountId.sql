SELECT
	`account`.`name` AS `account_name`
FROM
	`account`
WHERE
	`account`.`id` = :account_id
