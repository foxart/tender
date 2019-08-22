SELECT
	`purchaser_company`.`id` AS `company_id`,
	`purchaser_company`.`name` AS `company_name`
FROM
	`purchaser_company`
WHERE
	`purchaser_company`.`name` = :company_name
