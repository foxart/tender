DELETE FROM
	`rfq_cross_material`
WHERE

	`rfq_cross_material`.`rfq_id` =
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
		AND `rfq_cross_material`.`material_id` = :material_id
