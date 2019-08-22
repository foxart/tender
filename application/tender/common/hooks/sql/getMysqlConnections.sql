SELECT
	COUNT(`information_schema`.`processlist`.`id`) AS `connections_count`,
	`information_schema`.`processlist`.`db` AS `database_name`,
	`information_schema`.`processlist`.`user` AS `user_login`
FROM
	`information_schema`.`processlist`
GROUP BY
	`information_schema`.`processlist`.`db`,
	`information_schema`.`processlist`.`user`
