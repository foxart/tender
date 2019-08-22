SELECT
	`authorization`.`name` AS `authorization_name`
FROM
	`authorization`
WHERE
	`authorization`.`id` = :authorization_id
