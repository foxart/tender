SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			DISTINCT
			`temp`.*
		FROM
			(
				SELECT
					`rfq`.`id` AS `rfq_id`,
					`rfq`.`name` AS `rfq_name`,
# 					`rfq`.`date_publish` AS `rfq_date_publish`,
					`rfq`.`date_quote` AS `rfq_date_quote`,
					`rfq`.`date_question` AS `rfq_date_question`,
					`rfq`.`remark` AS `rfq_remark`,
					`rfq`.`term` AS `rfq_term`,
					`rfq`.`status` AS `rfq_status`,
					`purchaser_company`.`name` AS `purchaser_company_name`
				FROM
					`rfq`
					INNER JOIN
					`purchaser_company`
					ON `purchaser_company`.`id` = `rfq`.`purchaser_company_id`
					INNER JOIN
					`rfq_cross_vendor_company`
					ON `rfq_cross_vendor_company`.`rfq_id` = `rfq`.`id`
				WHERE
					`rfq_cross_vendor_company`.`vendor_company_id` IN (
						SELECT
							`vendor_company`.`id`
						FROM
							`vendor_company`
						WHERE
							`vendor_company`.`account_id` = :account_id
					)
			) AS `temp`,
			(
				SELECT
					@`row` := 0
			) AS `counter`
	) AS `records`
ORDER BY
	`rfq_id` ASC
