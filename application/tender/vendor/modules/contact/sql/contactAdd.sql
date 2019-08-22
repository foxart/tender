INSERT INTO
	`vendor_company_contact`
	(
		`company_id`,
		`person`,
		`title`,
		`position`,
		`email`,
		`phone`
	)
VALUES
	(
		(
			SELECT
				`vendor_company`.`id`
			FROM
				`vendor_company`
			WHERE
				`vendor_company`.`id` = :company_id
					AND
					`vendor_company`.`account_id` = :account_id
		),
		:contact_person,
		:contact_title,
		:contact_position,
		:contact_email,
		:contact_phone
	)
