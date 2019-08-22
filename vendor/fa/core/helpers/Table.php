<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;

/**
 * example of basic @param usage
 *
 * @param bool $baz
 *
 * @return mixed
 */
class Table extends Singleton {

	public static $instance;

	public function arrayToTable($array, $parameter = NULL) {
		if (isset($parameter['class']) === TRUE) {
			$table_class = $parameter['class'];
		} else {
			$table_class = '';
		};
		if (isset($parameter['thead']) === TRUE) {
			$header = $parameter['thead'];
		} else {
			$header = NULL;
		};
		ob_start();
		if (count($array) > 0) {
			$tr = 1;
			echo "<table class=\"{$table_class}\">" . PHP_EOL;
			foreach ($array as $row) {
				if ($tr & 1 == TRUE) {
					$evenOdd = 'odd';
				} else {
					$evenOdd = 'even';
				}
				$th = 1;
				if ($header === NULL) {
					if ($tr == 1) {
						echo "<thead>" . PHP_EOL;
						echo "<tr>" . PHP_EOL;
						foreach ($row as $key => $value) {
							echo "<th class=\"th_{$th}\">{$key}</th>" . PHP_EOL;
							$th++;
						}
						echo "</tr>" . PHP_EOL;
						echo "</thead>" . PHP_EOL;
						echo "<tbody>" . PHP_EOL;
					}
				} else {
					if ($tr == 1) {
						echo "<thead>" . PHP_EOL;
						echo "<tr>" . PHP_EOL;
						foreach ($header as $key => $value) {
							if (is_null($value) === TRUE) {
								echo "<th class=\"th_{$th}\">{$key}</th>" . PHP_EOL;
							} else {
								echo "<th class=\"th_{$th}\">$key {$value}</th>" . PHP_EOL;
							}
							$th++;
						}
						echo "</tr>" . PHP_EOL;
						echo "</thead>" . PHP_EOL;
						echo "<tbody>" . PHP_EOL;
					}
				}
				$td = 1;
				echo "<tr class=\"{$evenOdd}\">" . PHP_EOL;
				foreach ($row as $key => $value) {
					echo "<td class=\"tr_{$tr} td_{$td} td_{$key}\">{$value}</td>" . PHP_EOL;
					$td++;
				}
				echo "</tr>" . PHP_EOL;
				$tr++;
			}
			echo "</tbody>" . PHP_EOL;
			echo "</table>" . PHP_EOL;
		}
		$result = ob_get_clean();

		return $result;
	}
}
