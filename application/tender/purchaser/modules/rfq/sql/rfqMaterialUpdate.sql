UPDATE
	`rfq_cross_material`
SET
	`rfq_cross_material`.`quantity` = :rfq_material_quantity
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
