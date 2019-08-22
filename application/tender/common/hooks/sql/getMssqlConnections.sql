SELECT
	COUNT(`dbid`) AS `connections_count`,
	DB_NAME(`dbid`) AS `database_name`,
	LTRIM(RTRIM(`loginame`)) AS `user_login`
FROM
	`sys`.`sysprocesses`
WHERE
	`dbid` > 0
GROUP BY
	`dbid`,
	`loginame`
