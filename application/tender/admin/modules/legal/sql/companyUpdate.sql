UPDATE `purchaser_company`
SET
	`purchaser_company`.`name` = :company_name
WHERE
	`purchaser_company`.`id` = :company_id
