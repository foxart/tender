SELECT
	COUNT(*) AS `count`
FROM
	`rfq`
	INNER JOIN
	`rfq_cross_material`
	ON `rfq_cross_material`.`rfq_id` = `rfq`.`id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND
		`rfq_cross_material`.`material_id` = :material_id
