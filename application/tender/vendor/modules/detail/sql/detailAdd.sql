INSERT INTO `vendor_company_detail` (
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
				AND `vendor_company`.`account_id` = :account_id
	),
	(
		SELECT
			`geo`.`geoname_id`
		FROM
			`geo`
		WHERE
			`geo`.`country_name` = :detail_country
				AND
				`geo`.`subdivision_1_name` = :detail_region
				AND
				`geo`.`city_name` = :detail_city
		GROUP BY
			`geo`.`country_name`,
			`geo`.`subdivision_1_name`,
			`geo`.`city_name`
	),
	:detail_email,
	:detail_phone,
	:detail_postal,
	:detail_district,
	:detail_street,
	:detail_house
)
