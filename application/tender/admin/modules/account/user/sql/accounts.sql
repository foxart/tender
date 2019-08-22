SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`account`.`id` AS `account_id`,
			`authentication`.`email` AS `authentication_email`,
			`authentication`.`registration_date` AS `authentication_registration_date`,
			`account_type`.`name` AS `account_type_name`,
			`authentication`.`active` AS `authentication_active`,
			`account`.`authorization_id` AS `account_authorization_id`,
			`account`.`name` AS `account_name`,
			`authorization`.`name` AS `authorization_name`,
			`authentication`.`registration_code` AS `authentication_registration_code`
		FROM
			`account`
			INNER JOIN
			`authentication`
			ON `account`.`authentication_id` = `authentication`.`id`
			INNER JOIN
			`account_type`
			ON `account`.`account_type_id` = `account_type`.`id`
			LEFT JOIN
			`authorization`
			ON `account`.`authorization_id` = `authorization`.`id`
		WHERE
			IF(:account_name_filter = '', 1,
			   `account`.`name` LIKE CONCAT('%', :account_name_filter, '%')
			)
				AND IF(:account_type_id_filter = '', 1, `account_type`.`id` = :account_type_id_filter)
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
ORDER BY
	`records`.`account_id` DESC
