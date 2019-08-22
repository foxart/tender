DELETE FROM
	`rfq_cross_vendor_company`
WHERE

	`rfq_cross_vendor_company`.`rfq_id` =
		(
			SELECT
				`rfq`.`id`
			FROM
				`rfq`
			WHERE
				`rfq`.`account_id` = :account_id
					AND
					`rfq`.`id` = :rfq_id
		)
		AND `rfq_cross_vendor_company`.`vendor_company_id` = :company_id
