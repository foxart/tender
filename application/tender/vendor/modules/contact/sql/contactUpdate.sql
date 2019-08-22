UPDATE
	`vendor_company_contact`
SET
	`person` = :contact_person,
	`title` = :contact_title,
	`position` = :contact_position,
	`email` = :contact_email,
	`phone` = :contact_phone
WHERE
	`vendor_company_contact`.`company_id` = (
		SELECT
			`vendor_company`.`id`
		FROM
			`vendor_company`
		WHERE
			`vendor_company`.`id` = :company_id
				AND
				`vendor_company`.`account_id` = :account_id
	)
