SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`vendor_company_bank`.`id`,
			`vendor_company_bank`.`key`,
			`vendor_company_bank`.`account`,
			`vendor_company_bank`.`holder`
		FROM
			`vendor_company_bank`
		WHERE
			`vendor_company_bank`.`company_id` =
				(
					SELECT
						`vendor_company`.`id`
					FROM
						`vendor_company`
					WHERE
						`vendor_company`.`id` = :company_id
							AND
							`vendor_company`.`account_id` = :account_id
				)
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
