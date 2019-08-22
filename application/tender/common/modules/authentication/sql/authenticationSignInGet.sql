SELECT
	`account`.`id` AS `account_id`,
	`account`.`name` AS `account_name`,
	`account_type`.`id` AS `account_type_id`,
	`account_type`.`name` AS `account_type`,
	`authentication`.`id` AS `authentication_id`,
	`authentication`.`active` AS `authentication_active`,
	`authentication`.`email` AS `authentication_email`,
	`authentication`.`password_code` AS `authentication_password_code`,
	`authentication`.`registration_code` AS `authentication_registration_code`,
	`authorization`.`id` AS `authorization_id`,
	`authorization`.`name` AS `authorization_name`
FROM
	`account`
	INNER JOIN
	`account_type`
	ON `account_type`.`id` = `account`.`account_type_id`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
# 	INNER JOIN
	LEFT JOIN
	`authorization`
	ON `authorization`.`id` = `account`.`authorization_id`
WHERE
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
