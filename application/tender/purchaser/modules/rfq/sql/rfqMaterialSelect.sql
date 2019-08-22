SELECT
	`material`.`id` AS `material_id`,
	`material`.`name` AS `material_name`,
	`material_group`.`id` AS `material_group_id`,
	`material_group`.`name` AS `material_group_name`
FROM
	`rfq`
	INNER JOIN
	`purchaser_company_cross_account_cross_material`
	ON `purchaser_company_cross_account_cross_material`.`purchaser_company_id` = `rfq`.`purchaser_company_id` AND
		`purchaser_company_cross_account_cross_material`.`account_id` = :account_id
	INNER JOIN
	`material`
	ON `material`.`id` = `purchaser_company_cross_account_cross_material`.`material_id`
	INNER JOIN
	`material_group`
	ON `material_group`.`id` = `material`.`material_group_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND
		IF(:material_name IS NULL, 1, `material`.`name` LIKE CONCAT('%', :material_name, '%'))
		AND `material`.`id` NOT IN
		(
			SELECT
				`material_id`
			FROM
				`rfq_cross_material`
			WHERE
				`rfq_id` = :rfq_id
		)
