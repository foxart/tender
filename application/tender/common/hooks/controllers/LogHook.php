<?php

namespace tender\common\hooks\controllers;

use fa\classes\Controller;
use fa\core\classes\Statistic;
use fa\core\faf;

class LogHook extends Controller {

	public function statisticStart() {
		Statistic::start();
	}

	public function statisticEnd() {
		$statistic = Statistic::end();
		$data[] = 'time: ';
		$data[] = round($statistic['time']['duration'], 2) . ' ms / ' . $statistic['time']['limit'] . ' ms' . PHP_EOL;
		$data[] = 'memory: ';
		$data[] = round($statistic['memory']['difference'], 2) . ' mb / ';
		$data[] = round($statistic['memory']['peak_difference'], 2) . ' mb / ';
		$data[] = round($statistic['memory']['limit'] / 1024 / 1024, 2) . ' mb' . PHP_EOL;
		faf::io()->log('request', implode('', $data));
	}

	public function logRequest() {
		$data = array();
		$data[] = PHP_EOL . '[' . faf::request()->status . ']';
		if (faf::request()->method() === 'get') {
			$data[] = '[GET]';
		}
		if (faf::request()->method() === 'post') {
			$data[] = '[POST]';
		}
		if (faf::request()->file() !== NULL) {
			$data[] = '[FILE]';
		}
		if (faf::request()->isAjax === TRUE) {
			$data[] = '[AJAX]';
		}
		$data[] = ': ' . faf::request()->createUrl([
				'get' => faf::request()->get(),
			]) . PHP_EOL;
		$data[] = 'route: ' . faf::router()->route . PHP_EOL;
		if (faf::request()->get() !== NULL) {
			$data[] = 'get: ' . json_encode(faf::request()->get(), JSON_PRETTY_PRINT) . PHP_EOL;
		}
		if (faf::request()->post() !== NULL) {
			$data[] = 'post: ' . json_encode(faf::request()->post(), JSON_PRETTY_PRINT) . PHP_EOL;
		}
		if (faf::request()->file() !== NULL) {
			$data[] = 'files: ' . json_encode(faf::request()->file(), JSON_PRETTY_PRINT) . PHP_EOL;
		}
		faf::io()->log('request', implode('', $data));
	}
}


