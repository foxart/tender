UPDATE
	`vendor_company_detail`
SET
	`geo_id` =
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
	`email` = :detail_email,
	`phone` = :detail_phone,
	`postal` = :detail_postal,
	`district` = :detail_district,
	`street` = :detail_street,
	`house` = :detail_house
WHERE
	`vendor_company_detail`.`company_id` = (
		SELECT
			`vendor_company`.`id`
		FROM
			`vendor_company`
		WHERE
			`vendor_company`.`id` = :company_id
				AND
				`vendor_company`.`account_id` = :account_id
	)
