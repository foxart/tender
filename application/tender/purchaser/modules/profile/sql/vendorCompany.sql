SELECT
	DISTINCT
	`vendor_company`.`id` AS `company_id`,
	`vendor_company`.`name` AS `company_name`,
	`vendor_company_title`.`name` AS `company_title`,
	`vendor_company_type`.`name` AS `company_type`,
	`vendor_company_contact`.`email` AS `contact_email`,
	`vendor_company_contact`.`person` AS `contact_person`,
	`vendor_company_contact`.`phone` AS `contact_phone`,
	`vendor_company_contact`.`position` AS `contact_position`,
	`vendor_company_contact`.`title` AS `contact_title`,
	`vendor_company_detail`.`district` AS `detail_district`,
	`vendor_company_detail`.`street` AS `detail_street`,
	`vendor_company_detail`.`house` AS `detail_house`,
	`vendor_company_detail`.`postal` AS `detail_postal`,
	`vendor_company_detail`.`email` AS `detail_email`,
	`vendor_company_detail`.`phone` AS `detail_phone`,
	`vendor_company_factory`.`district` AS `factory_district`,
	`vendor_company_factory`.`street` AS `factory_street`,
	`vendor_company_factory`.`house` AS `factory_house`,
	`vendor_company_factory`.`postal` AS `factory_postal`,
	`vendor_company_factory`.`email` AS `factory_email`,
	`vendor_company_factory`.`phone` AS `factory_phone`,
	`vendor_company_excise_basis`.`name` AS `excise_basis`,
	`vendor_company_excise_tax`.`name` AS `excise_tax`,
	`vendor_company_excise`.`registration` AS `excise_registration`,
	`vendor_company_excise`.`registration_number` AS `excise_registration_number`,
	`vendor_company_excise`.`service` AS `excise_service`,
	`vendor_company_excise`.`service_number` AS `excise_service_number`,
	`vendor_company_excise`.`sales` AS `excise_sales`,
	`vendor_company_excise`.`sales_number` AS `excise_sales_number`,
	`vendor_company_excise`.`license` AS `excise_license`,
	`geo_company`.`country_name` AS `detail_country`,
	`geo_company`.`subdivision_1_name` AS `detail_region`,
	`geo_company`.`city_name` AS `detail_city`,
	`geo_factory`.`country_name` AS `factory_country`,
	`geo_factory`.`subdivision_1_name` AS `factory_region`,
	`geo_factory`.`city_name` AS `factory_city`
FROM
	`purchaser_company_cross_vendor_company`
	INNER JOIN
	`vendor_company`
	ON `purchaser_company_cross_vendor_company`.`vendor_company_id` = `vendor_company`.`id`
	INNER JOIN
	`vendor_company_title`
	ON `vendor_company_title`.`id` = `vendor_company`.`company_title_id`
	INNER JOIN
	`vendor_company_type`
	ON `vendor_company_type`.`id` = `vendor_company`.`company_type_id`
	LEFT JOIN
	`vendor_company_contact`
	ON `vendor_company`.`id` = `vendor_company_contact`.`company_id`
	LEFT JOIN
	`vendor_company_excise`
	ON `vendor_company_excise`.`company_id` = `vendor_company`.`id`
	LEFT JOIN
	`vendor_company_excise_basis`
	ON `vendor_company_excise_basis`.`id` = `vendor_company_excise`.`company_excise_basis_id`
	LEFT JOIN
	`vendor_company_excise_tax`
	ON `vendor_company_excise_tax`.`id` = `vendor_company_excise`.`company_excise_tax_id`
	LEFT JOIN
	`vendor_company_detail`
	ON `vendor_company_detail`.`company_id` = `vendor_company`.`id`
	LEFT JOIN
	`vendor_company_factory`
	ON `vendor_company_factory`.`company_id` = `vendor_company`.`id`
	LEFT JOIN
	`geo` AS `geo_company`
	ON `vendor_company_detail`.`geo_id` = `geo_company`.`geoname_id`
	LEFT JOIN
	`geo` AS `geo_factory`
	ON `vendor_company_factory`.`geo_id` = `geo_factory`.`geoname_id`
WHERE
	`purchaser_company_cross_vendor_company`.`vendor_company_id` =
		(
			SELECT
				DISTINCT
				`purchaser_company_cross_vendor_company`.`vendor_company_id`
			FROM
				`purchaser_company_cross_vendor_company`
			WHERE
				`purchaser_company_cross_vendor_company`.`purchaser_company_id` IN (
					SELECT
						`purchaser_company_cross_account`.`purchaser_company_id`
					FROM
						`purchaser_company_cross_account`
					WHERE
						`purchaser_company_cross_account`.`account_id` = :account_id
				)
					AND `purchaser_company_cross_vendor_company`.`vendor_company_id` = :company_id
		)
