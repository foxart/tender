INSERT INTO `vendor_company_factory` (
	`company_id`,
	`geo_id`,
	`email`,
	`phone`,
	`postal`,
	`district`,
	`street`,
	`house`
)
VALUES (
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
	:factory_email,
	:factory_phone,
	:factory_postal,
	:factory_district,
	:factory_street,
	:factory_house
)
