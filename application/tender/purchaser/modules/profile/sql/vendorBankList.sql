SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT

			`vendor_company_bank`.`key`,
			`vendor_company_bank`.`account`,
			`vendor_company_bank`.`holder`
		FROM
			`vendor_company`
			INNER JOIN
			`vendor_company_bank`
			ON `vendor_company_bank`.`company_id` = `vendor_company`.`id`
		WHERE
			`vendor_company`.`id` =
				(
					SELECT
						DISTINCT
						`purchaser_company_cross_vendor_company`.`vendor_company_id`
					FROM
						`purchaser_company_cross_vendor_company`
					WHERE
						`purchaser_company_cross_vendor_company`.`purchaser_company_id` IN (
							SELECT
								`purchaser_company_cross_account`.`purchaser_company_id`
							FROM
								`purchaser_company_cross_account`
							WHERE
								`purchaser_company_cross_account`.`account_id` = :account_id
						)
							AND `purchaser_company_cross_vendor_company`.`vendor_company_id` = :company_id
				)
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
