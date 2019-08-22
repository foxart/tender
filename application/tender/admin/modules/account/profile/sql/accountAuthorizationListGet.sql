SELECT
	`authorization`.`id` AS `id`,
	`authorization`.`name` AS `name`
FROM
	`authorization`
WHERE
	`authorization`.`account_type_id` = :authorization_account_type_id
