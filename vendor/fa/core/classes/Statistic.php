<?php

namespace fa\core\classes;

final class Statistic {

	private static $time;
	private static $memory_usage;
	private static $memory_peak_usage;

	public static function start() {
		static::$time = microtime(TRUE) * 1000;
		static::$memory_usage = memory_get_usage(FALSE) / 1024 / 1024;
		static::$memory_peak_usage = memory_get_peak_usage(FALSE) / 1024 / 1024;
	}

	public static function end() {
		$memory_usage = memory_get_usage(FALSE) / 1024 / 1024;
		$memory_peak_usage = memory_get_peak_usage(FALSE) / 1024 / 1024;
		$memory_limit = static::get_memory_limit();
		$time_end = microtime(TRUE) * 1000;
		$time_limit = static::get_time_limit();
		$result = [
			'time' => [
				'start' => self::$time,
				'end' => $time_end,
				'duration' => $time_end - self::$time,
				'limit' => $time_limit,
			],
			'memory' => [
				'start' => self::$memory_usage,
				'end' => $memory_usage,
				'difference' => $memory_usage - self::$memory_usage,
				'peak_start' => self::$memory_peak_usage,
				'peak_end' => $memory_peak_usage,
				'peak_difference' => $memory_peak_usage - self::$memory_peak_usage,
				'limit' => $memory_limit,
			],
		];

		return $result;
	}

	public static function get_memory_limit() {
		$matches = array();
		$result = NULL;
		$memory_limit_ini = ini_get('memory_limit');
		preg_match('/^(\d+)(.)$/', $memory_limit_ini, $matches);
		if ($matches[2] == 'M') {
			$result = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
//			$result = $matches[1] ; // nnnM -> nnn MB
		} elseif ($matches[2] == 'K') {
			$result = $matches[1] * 1024; // nnnK -> nnn KB
		}

		return $result;
	}

	public static function get_time_limit() {
		$time_limit_ini = ini_get('max_execution_time');
		$result = $time_limit_ini * 1000;

		return $result;
	}

//	public static function fill_memory($segment_size = 8) {
//		$memory_peak_usage_start = memory_get_peak_usage(FALSE);
//		$min_segment_size = 128;
//		$max_segment_size = 1024;
//		if ((int)$segment_size < $min_segment_size or (int)$segment_size > $max_segment_size) {
//			$segment_size_kb = $min_segment_size * 1024;
//		} else {
//			$segment_size_kb = (int)$segment_size * 1024;
//		}
//		$data = NULL;
//		$i = 0;
//		while (TRUE) {
//			$memory_usage = memory_get_usage(FALSE);
//			$memory_peak_usage = memory_get_peak_usage(FALSE);
//			if ($memory_peak_usage + $memory_peak_usage_start >= static::$memory_limit * 0.9) {
//				break;
//			}
//			$data = $data . str_repeat(' ', $segment_size_kb);
//			$i++;
//		}
//		$php_time = microtime(TRUE) - static::$time_start;
//		$memory_test_format = "time: <b>%.2f</b> ms <br/>cycles: <b>%d</b> of <b>%d</b> kb <br/>memory: <b>%.2f</b> / <b>%.2f</b> of <b>%.2f</b> mb ";
//		$result = sprintf($memory_test_format, $php_time * 1000, $i, $segment_size_kb / 1024, $memory_usage / 1024 / 1024,
//			$memory_peak_usage / 1024 / 1024, static::$memory_limit / 1024 / 1024);
//
//		return $result;
//	}
}
