SELECT
	COUNT(*) AS `count`
FROM
	`authentication`
WHERE
	`authentication`.`active` = TRUE
		AND
		`authentication`.`email` = :authentication_email
		AND
		`authentication`.`password` = MD5(
			CONCAT(
				MD5(:authentication_password), (
					SELECT
						`authentication`.`password_salt`
					FROM
						`authentication`
					WHERE
						`authentication`.`email` = :authentication_email
				)
			)
		)
