INSERT INTO
	`material` (
		`material`.`material_group_id`,
		`material`.`material_uom_id`,
		`material`.`name`,
		`material`.`description`,
		`material`.`po`
	)
VALUES (
	:material_group_id,
	:material_uom_id,
	:material_name,
	:material_description,
	:material_po
)
