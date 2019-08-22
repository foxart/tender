SELECT
	`vendor_company_contact`.`person` AS `contact_person`,
	`vendor_company_contact`.`title` AS `contact_title`,
	`vendor_company_contact`.`position` AS `contact_position`,
	`vendor_company_contact`.`email` AS `contact_email`,
	`vendor_company_contact`.`phone` AS `contact_phone`
FROM
	`vendor_company_contact`
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
