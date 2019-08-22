SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`vendor_company`.`id`,
			`vendor_company`.`name`,
			`vendor_company_title`.`name` AS `title`,
			`vendor_company_type`.`name` AS `type`
		FROM
			`vendor_company`
			INNER JOIN
			`vendor_company_title`
			ON `vendor_company`.`company_title_id` = `vendor_company_title`.`id`
			INNER JOIN
			`vendor_company_type`
			ON `vendor_company`.`company_type_id` = `vendor_company_type`.`id`
		WHERE
			`vendor_company`.`account_id` = :account_id
# 		LIMIT 10
# 		OFFSET 0
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
