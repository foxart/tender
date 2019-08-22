SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`purchaser_company`.`id` AS `company_id`,
			`purchaser_company`.`name` AS `company_name`
		FROM
			`purchaser_company`
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`

