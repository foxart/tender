SELECT
	`account`.`authorization_id` AS `authorization_id`
FROM
	`account`
WHERE
	`account`.`id` = :account_id
