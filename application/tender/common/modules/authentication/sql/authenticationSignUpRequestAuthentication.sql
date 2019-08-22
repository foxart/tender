INSERT INTO
	`authentication` (
		`authentication`.`active`,
		`authentication`.`email`,
		`authentication`.`password`,
		`authentication`.`password_salt`,
		`authentication`.`registration_code`,
		`authentication`.`registration_date`
	)
VALUES (
	DEFAULT,
	:authentication_email,
	MD5(
		CONCAT(
			MD5(:authentication_password), :authentication_password_salt
		)
	),
	:authentication_password_salt,
	:authentication_registration_code,
	CURRENT_TIMESTAMP
)
