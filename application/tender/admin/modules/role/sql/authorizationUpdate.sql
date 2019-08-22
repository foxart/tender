UPDATE `authorization`
SET `authorization`.`name` = :authorization_name
WHERE
	`authorization`.`id` = :authorization_id
