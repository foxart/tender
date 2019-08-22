SELECT
	`geo`.`country_name` AS `factory_country`,
	`geo`.`subdivision_1_name` AS `factory_region`,
	`geo`.`city_name` AS `factory_city`,
	`vendor_company_factory`.`district` AS `factory_district`,
	`vendor_company_factory`.`street` AS `factory_street`,
	`vendor_company_factory`.`house` AS `factory_house`,
	`vendor_company_factory`.`postal` AS `factory_postal`,
	`vendor_company_factory`.`email` AS `factory_email`,
	`vendor_company_factory`.`phone` AS `factory_phone`
FROM
	`vendor_company_factory`
	INNER JOIN
	`geo`
	ON `geo`.`geoname_id` = `vendor_company_factory`.`geo_id`
WHERE
	`vendor_company_factory`.`company_id` = (
		SELECT
			`vendor_company`.`id`
		FROM
			`vendor_company`
		WHERE
			`vendor_company`.`id` = :company_id
				AND
				`vendor_company`.`account_id` = :account_id
	)

