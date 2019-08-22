SELECT
	`purchaser_company`.`name` AS `company_name`
FROM
	`purchaser_company`
WHERE
	`purchaser_company`.`id` = :company_id
