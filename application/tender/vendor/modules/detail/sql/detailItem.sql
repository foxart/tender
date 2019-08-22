SELECT
	`geo`.`country_name` AS `detail_country`,
	`geo`.`subdivision_1_name` AS `detail_region`,
	`geo`.`city_name` AS `detail_city`,
	`vendor_company_detail`.`district` AS `detail_district`,
	`vendor_company_detail`.`street` AS `detail_street`,
	`vendor_company_detail`.`house` AS `detail_house`,
	`vendor_company_detail`.`postal` AS `detail_postal`,
	`vendor_company_detail`.`email` AS `detail_email`,
	`vendor_company_detail`.`phone` AS `detail_phone`
FROM
	`vendor_company_detail`
	INNER JOIN
	`geo`
	ON `geo`.`geoname_id` = `vendor_company_detail`.`geo_id`
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
