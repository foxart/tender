INSERT INTO `account` (
	`account`.`account_type_id`,
	`account`.`authentication_id`,
	`account`.`authorization_id`,
	`account`.`name`
)
VALUES (
	:account_type_id,
	:authentication_id,
	:authorization_id,
	:account_name
)
