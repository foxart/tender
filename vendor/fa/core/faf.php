<?php

namespace fa\core;

use fa\core\system\Connector;

final class faf extends Connector {

	public static $instance;
	public static $faf;
	public static $configuration;

	private static function generateError($router, $output_buffer) {
		faf::header()->setStatusCode(500);
//		if (self::request()->isAjax === TRUE) {
//		if (strpos(self::request()->accept, 'application/json') !== FALSE) {
//			$message = [
//				'faf' => [
//					'error' => [
//						'message' => 'Controller has performed unexpected output',
//						'controller' => [
//							'class' => $router['controller'],
//							'method' => $router['action'],
//						],
//						'output' => htmlentities($output_buffer),
//					],
//				],
//			];
//
//			return json_encode($message, JSON_PRETTY_PRINT);
//		} else {
			$message = [
				'{{ message }}' => 'Application has performed unexpected output',
				'{{ controller }}' => $router['controller'],
				'{{ action }}' => $router['action'],
				'{{ arguments }}' => highlight_string('<?php' . PHP_EOL . var_export([], TRUE) . PHP_EOL . '?>', TRUE),
				'{{ output }}' => $output_buffer,
				'{{ backtrace }}' => '',
			];
			$subject = '
				<div style="padding:10px;font-size:13px;font-family:monospace;background-color:seashell;">
					<div><h3>{{ message }}</h3></div>
					<div>controller: <b>{{ controller }}</b></div>
					<div>action: <b>{{ action }}</b></div>
					<div>arguments: <b>{{ arguments }}</b></div>
				</div>
				{{ output }}
			';
			faf::header()->setContentType(faf::helper()->getContentTypeByExtension('html'));

			return str_replace(array_keys($message), array_values($message), $subject);
//		}
	}

	public static function run($configuration) {
		/**
		 * @type \fa\classes\Configuration $configuration
		 */
		ob_start();
		self::$configuration = $configuration::get();
//		dump(self::$configurations);
//		exit;
		self::router()->parse(self::$configuration['routes']);
		self::handleHook(self::$configuration['application_before']);
//		self::handleHook(self::router()->action_before);
//		$result = self::executeController(self::router()->controller, self::router()->action,
//			self::router()->arguments);
//		self::handleHook(self::router()->action_after);
//		dump(self::router()->trigger);
//		exit;
//		$result = self::handleController(self::router()->controller, self::router()->action, self::router()->arguments,
//			self::router()->action_before, self::router()->action_after, self::router()->chain);
		$result = self::handleRoute(self::router()->trigger);
		self::handleHook(self::$configuration['application_after']);
		if (ob_get_length() === 0) {
			ob_get_clean();
			echo $result;
		} else {
			echo self::generateError(self::router()->trigger, ob_get_clean());
		}
//		dump($content);
//		echo "<b>[{$length}]</b>";
	}

	/**
	 * @param array $hook_list
	 */
	private static function handleHook($hook_list) {
//		dump($hook_list);
//		exit;
		if (empty($hook_list) === FALSE) {
			foreach ($hook_list as $hook) {
				self::executeController($hook['controller'], $hook['action'], $hook['arguments']);
			}
		}
	}

	private static function handleRoute($route) {
		$route = self::normalizeRoute($route);
		self::handleHook($route['action_before']);
		if (empty($route['trigger']) === TRUE) {
			$result = self::executeController($route['controller'], $route['action'], $route['arguments']);
		} else {
			$trigger = self::normalizeRoute($route['trigger']);
//			$trigger['arguments']['controller'] = self::executeController($route['controller'], $route['action'], $route['arguments']);
//			$trigger['arguments']['trigger'] = self::executeController($route['controller'], $route['action'], $route['arguments']);
			$trigger['arguments']['trigger'] = self::executeController($route['controller'], $route['action'], $route['arguments']);
			$result = self::handleRoute($trigger);
		}
		self::handleHook($route['action_after']);

		return $result;
	}

	private static function normalizeRoute($array) {
		if (isset($array['controller']) === TRUE) {
			$result['controller'] = $array['controller'];
		} else {
			$result['controller'] = NULL;
		}
		if (isset($array['action_before']) === TRUE) {
			$result['action_before'] = $array['action_before'];
		} else {
			$result['action_before'] = NULL;
		}
		if (isset($array['action']) === TRUE) {
			$result['action'] = $array['action'];
		} else {
			$result['action'] = NULL;
		}
		if (isset($array['action_after']) === TRUE) {
			$result['action_after'] = $array['action_after'];
		} else {
			$result['action_after'] = NULL;
		}
		if (isset($array['arguments']) === TRUE) {
			$result['arguments'] = $array['arguments'];
		} else {
			$result['arguments'] = NULL;
		}
		if (isset($array['trigger']) === TRUE) {
			$result['trigger'] = $array['trigger'];
		} else {
			$result['trigger'] = NULL;
		}

		return $result;
	}

	/**
	 * @param $class
	 * @param $method
	 * @param null $arguments
	 *
	 * @return \fa\classes\Controller
	 * @throws \Exception
	 */
	public static function executeController($class, $method, $arguments = NULL) {
		/**
		 * @var \fa\classes\Controller $class
		 * @var \fa\classes\Controller $controller
		 * @var mixed $arguments
		 */
		if (class_exists($class) === FALSE) {
			throw  new \Exception('class not found: ' . $class);
		}
		if (method_exists($class, $method) === FALSE) {
			throw  new \Exception('method not found: ' . $method);
		}
		$index = (string)$class;
		if (isset(self::$faf[$index]) === FALSE) {
//			echo $class;
//			exit;
			self::$faf[$index] = new $class();
		}
		if (is_null($arguments) === TRUE) {
//			faf::io()->log('faf', $arguments);
			return self::$faf[$index]->$method();
		} else {
//			$ref = new \ReflectionMethod($class, $method);
//			foreach ($ref->getParameters() as $parameter) {
//				faf::io()->log('faf', $parameter);
//			}
			return call_user_func_array(array(
				self::$faf[$index],
				$method,
			), [
				$arguments,
			]);
		}
	}
}
