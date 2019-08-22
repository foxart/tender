UPDATE
	`material`
SET
	`material_group_id` = :material_group_id,
	`material_uom_id` = :material_uom_id,
	`name` = :material_name,
	`description` = :material_description,
	`po` = :material_po
WHERE
	`id` = :material_id
