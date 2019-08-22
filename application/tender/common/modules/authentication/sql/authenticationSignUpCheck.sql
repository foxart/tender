SELECT
	COUNT(*) AS `count`
FROM
	`authentication`
WHERE
	`authentication`.`email` = :authentication_email


