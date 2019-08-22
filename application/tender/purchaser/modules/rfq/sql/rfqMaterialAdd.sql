INSERT INTO
	`rfq_cross_material`
	(
		`rfq_id`,
		`material_id`,
		`quantity`
	)
VALUES
	(
		(
			SELECT
				`rfq`.`id`
			FROM
				`rfq`
			WHERE
				`rfq`.`account_id` = :account_id
					AND
					`rfq`.`id` = :rfq_id
		),
		:material_id,
		:rfq_material_quantity
	)
