INSERT INTO `vendor_company` (
	`vendor_company`.`account_id`,
	`vendor_company`.`company_title_id`,
	`vendor_company`.`company_type_id`,
	`vendor_company`.`name`
)
VALUES (
	:account_id,
	:company_title_id,
	:company_type_id,
	:company_name
)
