SELECT
	`material`.`id` AS `material_id`,
	`material`.`name` AS `material_name`,
	`material_group`.`id` AS `material_group_id`,
	`material_group`.`name` AS `material_group_name`
FROM
	`material`
	INNER JOIN
	`material_group`
	ON `material`.`material_group_id` = `material_group`.`id`
WHERE
	`material`.`id` NOT IN (
		SELECT
			`purchaser_company_cross_account_cross_material`.`material_id`
		FROM
			`purchaser_company_cross_account_cross_material`
		WHERE
			`purchaser_company_cross_account_cross_material`.`account_id` = :account_id
				AND `purchaser_company_cross_account_cross_material`.`purchaser_company_id` = (
				SELECT
					`purchaser_company_cross_account`.`purchaser_company_id`
				FROM
					`purchaser_company_cross_account`
				WHERE
					`purchaser_company_cross_account`.`purchaser_company_id` = :company_id
						AND
						`purchaser_company_cross_account`.`account_id` = :account_id
			)
	)
		AND
		IF(:material_name IS NULL, 1,
		   `material`.`name` LIKE CONCAT(
			   '%', :material_name, '%'
		   )
		)
