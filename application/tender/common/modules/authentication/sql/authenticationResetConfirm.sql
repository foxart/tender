UPDATE
	`authentication`
SET
	`authentication`.`password` = MD5(
		CONCAT(
			MD5(:authentication_password), :authentication_password_salt
		)
	),
	`authentication`.`password_salt` = :authentication_password_salt,
	`authentication`.`password_code` = NULL
WHERE
	`authentication`.`password_code` = :authentication_password_code
