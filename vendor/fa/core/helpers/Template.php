<?php

namespace fa\core\helpers;

use fa\core\faf;

final class Template {

	private $template;
	private $path;

	public function load($template) {
//		$backtrace = faf::backtrace();
//			faf::$configuration['paths']['application'] . dirname(dirname($backtrace->getCalleeClass(2))) . '/templates/' . $template,
		$template_directory = [
			faf::$configuration['paths']['themes'] . faf::$configuration['theme'] . '/templates/',
			faf::$configuration['paths']['application'],
			FA_PATH,
		];
		$found = FALSE;
		foreach ($template_directory as $directory) {
			if (faf::io()->checkFile($directory . $template) === TRUE) {
				$found = TRUE;
				$this->path = $directory . $template;
				break;
			}
		}
		if ($found === FALSE) {
			throw new \Exception('template not found: ' . $template . "\nin [\n" . implode(PHP_EOL, $template_directory) . "\n]");
		}
		$directory = faf::io()->loadFile($this->path);
		/*
		 * remove twig comments
		 */
//		$this->template = preg_replace("/{#[^#}]+#}/s", '', $file);
//		$this->template = preg_replace("/{#.+?#}/s", '', $file);
		/*
		 * replace twig with html comments
		 */
//		$this->template = preg_replace('/({#)(.+?)(#})/s', '<!--$1$2$3-->', $file);
		$this->template = preg_replace('/({#)(.+?)(#})/s', '<!--$2-->', $directory);

		return $this;
	}

	public function set($variables) {
		foreach ($variables as $variableKey => $variableValue) {
			$search = "{{ $variableKey }}";
			$replace = $variableValue;
			$subject = $this->template;
			if (strpos($subject, $search) === FALSE) {
				throw new \Exception("pattern not found: {$this->path}, {$search}");
			}
			$this->template = str_replace($search, $replace, $subject);
		}

		return $this;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function render($type = FALSE) {
		switch ($type) {
			case 'string':
				$result = implode('', $this->template);
				break;
			default:
				$result = $this->template;
				break;
		}

		return $result;
	}
}
