SELECT
	count('*') AS 'count'
FROM
	`purchaser_company`
WHERE
	`purchaser_company`.`name` = :company_name
		AND `purchaser_company`.`id` != :company_id
