SELECT
	`file`
FROM
	`purchaser_company_cross_account_cross_material`
WHERE
	`file` IS NOT NULL
UNION
SELECT
	`file`
FROM
	`vendor_company_cross_account_cross_material`
WHERE
	`file` IS NOT NULL

