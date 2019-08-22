SELECT
	`material`.`name` AS `material_name`,
	`material_group`.`name` AS `material_group_name`,
	`vendor_company_cross_account_cross_material`.`title` AS `material_title`,
	`vendor_company_cross_account_cross_material`.`file` AS `material_file`
FROM
	`vendor_company_cross_account_cross_material`
	INNER JOIN
	`material`
	ON `vendor_company_cross_account_cross_material`.`material_id` = `material`.`id`
	INNER JOIN
	`material_group`
	ON `material`.`material_group_id` = `material_group`.`id`
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
		AND `vendor_company_cross_account_cross_material`.`material_id` = :material_id
