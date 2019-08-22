UPDATE
	`authentication`
SET
	`authentication`.`password_code` = :authentication_password_code
WHERE
	`authentication`.`id` = (
		SELECT
			`account`.`authentication_id`
		FROM
			`account`
		WHERE
			`account`.`authentication_id` = :account_id
	)
		AND `authentication`.`registration_code` IS NULL
