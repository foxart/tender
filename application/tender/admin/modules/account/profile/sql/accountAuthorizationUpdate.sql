UPDATE `account`
SET `account`.`authorization_id` = :authorization_id
WHERE
	`account`.`id` = :account_id
