SELECT
	`vendor_company`.`id`,
	`vendor_company`.`name`
FROM
	`vendor_company`
WHERE
	`vendor_company`.`account_id` = :account_id

