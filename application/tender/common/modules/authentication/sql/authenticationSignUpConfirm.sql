UPDATE
	`authentication`
SET
	`authentication`.`registration_code` = NULL
WHERE
	`authentication`.`registration_code` = :authentication_registration_code
