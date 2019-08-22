SELECT
	COUNT(*) AS `count`
FROM
	`authentication`
WHERE
	`authentication`.`email` = :authentication_email
		AND
		`authentication`.`registration_code` IS NULL

