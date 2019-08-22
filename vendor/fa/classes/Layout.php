<?php

namespace fa\classes;

use fa\core\faf;
use fa\core\helpers\Template;

final class Layout implements LayoutInterface {

	private $template;

	public final function outputLayout($arguments) {
		$template = $arguments['template'];
		$this->template($template)->load($arguments['template'])->set($this->buildStructure($arguments['layout']));
		if (isset($arguments['trigger']) === TRUE) {
			$this->template($template)->set([
				'trigger' => $arguments['trigger'],
			]);
		}

		return $this->template($template)->render();
	}

	/*
	 * HEAD
	 */
	public final function outputHead($arguments) {
		/**
		 * @type \fa\classes\Configuration $map
		 */
		$map = $arguments['map'];
		$css = $this->buildCss($map::get('css'));
		$js = $this->buildJs($map::get('js'));

		return $css . $js;
	}

	public final function outputBootstrapMenu($arguments) {
		/**
		 * @type \fa\classes\Menu $map
		 */
		$map = $arguments['map'];

		return faf::menu()->renderBootstrapMenu($map::get(), $arguments['class']);
	}

	private function output($path) {
		$path_info = faf::helper()->getFileInfo($path);
		faf::header()->clear();
		faf::header()->setAcceptRanges('bytes');
		faf::header()->setLastModified(date(DATE_RFC2822, $path_info['modification']));
		faf::header()->setContentLength($path_info['size']);
//		faf::header()->setContentType('application/x-font-woff2');
//		header("Expires: " . gmstrftime("%a, %d %b %Y %H:%M:%S GMT", time() + 365*86440));
//		header("Cache-Control: max-age=" . 60 * 60 * 24);
		if (faf::helper()->checkExtension($path_info['extension']) === TRUE) {
			faf::header()->setContentType(faf::helper()->getContentTypeByExtension($path_info['extension']));
		}

		return faf::io()->loadFile($path);
	}

	public function outputFont() {
		$path = faf::$configuration['paths']['fonts'] . faf::router()->matches['file'];
		if (faf::io()->checkFile($path) === FALSE) {
			faf::header()->setStatusCode(404);

			return "font not found: {$path}";
		} else {
			return $this->output($path);
		}
	}

	public function outputFile() {
		$path = faf::$configuration['paths']['files'] . faf::router()->matches['file'];
		if (faf::io()->checkFile($path) === FALSE) {
			faf::header()->setStatusCode(404);

			return "file not found: {$path}";
		} else {
			return $this->output($path);
		}
	}

	public function outputPlugin() {
		$path = faf::$configuration['paths']['plugins'] . faf::router()->matches['file'];
		if (faf::io()->checkFile($path) === FALSE) {
			faf::header()->setStatusCode(404);

			return "plugin not found: {$path}";
		} else {
			return $this->output($path);
		}
	}

	public function outputTheme() {
		$path = faf::$configuration['paths']['themes'] . faf::router()->matches['file'];
		if (faf::io()->checkFile($path) === FALSE) {
			faf::header()->setStatusCode(404);

			return "theme not found: {$path}";
		} else {
			return $this->output($path);
		}
	}

	/*
	 *
	 */
	private final function buildStructure($structure) {
		$result = array();
		foreach ($structure as $key => $value) {
			if (isset($value['arguments']) === TRUE) {
				$result[$key] = faf::executeController($value['controller'], $value['action'], $value['arguments']);
			} else {
				$result[$key] = faf::executeController($value['controller'], $value['action']);
			}
		}

		return $result;
	}

	private function buildCss($css) {
		$css_array = array();
		$tag = 'link';
		foreach ($css as $css_key => $css_value) {
			if ($css_key === 'themes') {
				$css_url = faf::$configuration['urls'][$css_key] . faf::$configuration['theme'] . '/';
			} elseif ($css_key === 'plugins') {
				$css_url = faf::$configuration['urls'][$css_key];
			} elseif ($css_key === 'fonts') {
				$css_url = faf::$configuration['urls'][$css_key];
			} else {
				throw new \Exception('wrong configuration index: ' . $css_key);
			}
			foreach ($css_value as $css_file) {
				$css_array[] = "<{$tag} href=\"{$css_url}{$css_file}\" type=\"text/css\" rel=\"stylesheet\">";
			}
		}
		$result = implode(PHP_EOL, $css_array);

		return $result;
	}

	private final function buildJs($js) {
		$js_array = array();
		$tag = 'script';
		foreach ($js as $js_key => $js_value) {
			if ($js_key === 'themes') {
				$js_url = faf::$configuration['urls'][$js_key] . faf::$configuration['theme'] . '/';
			} elseif ($js_key === 'plugins') {
				$js_url = faf::$configuration['urls'][$js_key];
			} else {
				throw new \Exception('wrong configuration index: ' . $js_key);
			}
			foreach ($js_value as $js_file) {
				$js_array[] = "<{$tag} src=\"{$js_url}{$js_file}\" type=\"text/javascript\"></{$tag}>";
			}
		}
		$result = implode(PHP_EOL, $js_array);

		return $result;
	}

	/**
	 * @param $template
	 *
	 * @return \fa\core\helpers\Template
	 */
	private final function template($template) {
		if (isset($this->template[$template]) === FALSE) {
			$this->template[$template] = new Template();
		}

		return $this->template[$template];
	}
}
