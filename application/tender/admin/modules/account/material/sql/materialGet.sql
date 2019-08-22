SELECT
# 	`material`.`id` AS `material_id`,
	`material`.`name` AS `material_name`,
# 	`material_group`.`id` AS `material_group_id`,
	`material_group`.`name` AS `material_group_name`,
	`purchaser_company_cross_account_cross_material`.`title` AS `material_title`,
	`purchaser_company_cross_account_cross_material`.`file` AS `material_file`
FROM
	`purchaser_company_cross_account_cross_material`
	INNER JOIN
	`material`
	ON `purchaser_company_cross_account_cross_material`.`material_id` = `material`.`id`
	INNER JOIN
	`material_group`
	ON `material`.`material_group_id` = `material_group`.`id`
WHERE
	`purchaser_company_cross_account_cross_material`.`account_id` = :account_id
		AND `purchaser_company_cross_account_cross_material`.`purchaser_company_id` = (
		SELECT
			`purchaser_company_cross_account`.`purchaser_company_id`
		FROM
			`purchaser_company_cross_account`
		WHERE
			`purchaser_company_cross_account`.`purchaser_company_id` = :company_id
				AND `purchaser_company_cross_account`.`account_id` = :account_id
	)
		AND `purchaser_company_cross_account_cross_material`.`material_id` = :material_id
