SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`authorization`.`id` AS `authorization_id`,
			`account_type`.`name` AS `account_type_name`,
			`authorization`.`name` AS `authorization_name`
		FROM
			`authorization`
			LEFT JOIN
			`account_type`
			ON `authorization`.`account_type_id` = `account_type`.`id`
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
ORDER BY
	`records`.`authorization_id` ASC
