UPDATE
	`vendor_company_factory`
SET
	`geo_id` =
	(
		SELECT
			`geo`.`geoname_id`
		FROM
			`geo`
		WHERE
			`geo`.`country_name` = :factory_country
				AND
				`geo`.`subdivision_1_name` = :factory_region
				AND
				`geo`.`city_name` = :factory_city
		GROUP BY
			`geo`.`country_name`,
			`geo`.`subdivision_1_name`,
			`geo`.`city_name`
	),
	`email` = :factory_email,
	`phone` = :factory_phone,
	`postal` = :factory_postal,
	`district` = :factory_district,
	`street` = :factory_street,
	`house` = :factory_house
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
