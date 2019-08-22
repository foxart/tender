SELECT
	count(`authorization`.`id`) AS `count`
FROM
	`authorization`
WHERE
	`authorization`.`name` = :authorization_name
		AND `authorization`.`id` != :authorization_id
