SELECT
	`authentication`.`id`
FROM
	`authentication`
WHERE
	`authentication`.`email` = :authentication_email
ORDER BY
	`authentication`.`id` DESC
