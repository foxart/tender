SELECT
	`authorization`.`id` AS `authorization_id`
FROM
	`authorization`
WHERE
	`authorization`.`name` = :authorization_name
