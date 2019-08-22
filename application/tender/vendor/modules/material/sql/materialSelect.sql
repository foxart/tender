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
			`vendor_company_cross_account_cross_material`.`material_id`
		FROM
			`vendor_company_cross_account_cross_material`
		WHERE
			`vendor_company_cross_account_cross_material`.`account_id` = :account_id
				AND `vendor_company_cross_account_cross_material`.`vendor_company_id` =
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
	)
		AND
		IF(:material_name IS NULL, 1,
		   `material`.`name` LIKE CONCAT(
			   '%', :material_name, '%'
		   )
		)
