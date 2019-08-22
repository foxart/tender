<?php

namespace fa\core\services;

use fa\core\classes\Singleton;

final class RouterNew extends Singleton {

	public static $instance;
	public $controller;
	public $action;
	public $layout;
	public $parameters;
	public $data;
	public $action_before;
	public $action_after;
	public $compare;
	public $chain;
	public $route;
	public $routes;
	/**
	 * @var
	 */
	private $url_to;

	private function getRouteParameters($route) {
		/*
		 * route parameters map
		 */
		$route_parameters = NULL;
		preg_match_all('#(?<=[:])[a-zA-Z0-9]+#', $route, $route_parameters);
		if (count($route_parameters) === 0) {
			$result = FALSE;
		} else {
			$result = $route_parameters[0];
		}

		return $result;
	}

	private function getRoutePattern($route, $route_parameters, $route_constraints) {
		/*
		 * route pattern map
		 */
//		dump($route_parameters);
//		$route_parameters = array_keys($route_constraints);
//		dump($route_parameters);
//		echo '<hr/>';
		$route_parameters_map = array(
			'#\[#' => '(?:',
			'#\]#' => ')?',
		);
		foreach ($route_parameters as $item) {
//			$key = "#:{$item}\b#";
			$key = "#:{$item}#";
			if (isset($route_constraints[$item]) === TRUE) {
				$route_parameters_map[$key] = "({$route_constraints[$item]})";
			} else {
				$route_parameters_map[$key] = '([^/]+)';
			}
		}
//		dump($route_parameters_map);
		/*
		 * route matches
		 */
		$pattern = array_keys($route_parameters_map);
//		var_dump($pattern);
		$replacement = array_values($route_parameters_map);
		$result = preg_replace($pattern, $replacement, $route);

		return $result;
	}

	private function parseRouteLiteral($route) {
		$route_subject = $route['compare'];
		if ($route_subject === $route['route_template']) {
			$route_matches = array();
		} else {
			$route_matches = FALSE;
		}
		$result = $route_matches;

		return $result;
	}

	private function parseRouteSegment($route) {
		$route_subject = $route['compare'];
		$route_pattern = "#\\A{$route['route_pattern']}\\Z#";
		$route_matches = NULL;
		preg_match($route_pattern, $route_subject, $route_matches);
		foreach ($route_matches as $key => $item) {
			if ($item === '') {
				$route_matches[$key] = NULL;
			}
		}
		if (count($route_matches) === 0) {
			$result = FALSE;
		} else {
			array_shift($route_matches);
			$result = array();
			foreach ($route['parameters'] as $key => $item) {
				if (isset($route_matches[$key]) === TRUE) {
					$result[$item] = $route_matches[$key];
				} else {
					$result[$item] = NULL;
				}
			}
		}

		return $result;
	}

	private function normalizeRoute($route) {
		return array_replace(array(
			'route' => NULL,
			'compare' => 'path',
			'behaviour' => 'break',
			'parameters' => array(),
			'constraints' => array(),
			'route_pattern' => NULL,
			'route_template' => NULL,
			'route_parameters' => array(),
//			'route_breadcrumbs' => array(),
			'trigger' => array(
				'controller' => 'controllerIndex',
				'action' => 'actionIndex',
				'layout' => NULL,
				'action_before' => array(),
				'action_after' => array(),
				'data' => array(),
			),
		), $route);
	}

	private function prepareRoute($route_parent, $current_route) {
//		var_dump($route_parent['parameters']);
//		var_dump($route_current['parameters']);
		$result = array();
		$current_route['parameters'] = $this->getRouteParameters($current_route['route']);
		if ($current_route['compare'] === 'path') {
			$result['compare'] = $this->compare;
		}
		$result['behaviour'] = $current_route['behaviour'];
//		$result['hmvc'] = array_replace($route_parent['hmvc'], $route_current['hmvc']);
		$result['defaults'] = array_replace_recursive($route_parent['defaults'], $current_route['defaults']);
//		$result['route_breadcrumbs'][] = $current_route['route'];
		$result['route'] = $current_route['route'];
		$result['route_template'] = $route_parent['route_template'] . $current_route['route'];
		$result['parameters'] = array_merge($route_parent['parameters'], $current_route['parameters']);
		if (count($this->getRouteParameters($current_route['route'])) > 0) {
			$result['constraints'] = array_replace($route_parent['constraints'], $current_route['constraints']);
			$result['route_pattern'] = $route_parent['route_pattern'] . $this->getRoutePattern($current_route['route'], $current_route['parameters'],
					$current_route['constraints']);
		} else {
			$result['constraints'] = $route_parent['constraints'];
			$result['route_pattern'] = $route_parent['route_pattern'] . $current_route['route'];
		}

//		var_dump($result['parameters']);
		return $result;
	}

	private function parseRoute($key, $route) {
//		var_dump($route);
//			$result['route']['breabcrumbs'][] = $key;
		if (count($route['parameters']) > 0) {
			$route_matches = $this->parseRouteSegment($route);
		} else {
			$route_matches = $this->parseRouteLiteral($route);
		}
		if ($route_matches !== FALSE) {
//			dump($route);
			$this->controller = $route['defaults']['controller'];
			$this->action = $route['defaults']['action'];
			$this->layout = $route['defaults']['layout'];
			$this->parameters = $route_matches;
			$this->action_before = $route['defaults']['action_before'];
			$this->action_after = $route['defaults']['action_after'];
			$this->data = $route['defaults']['data'];
			$this->route = [
				'key' => $key,
				'value' => $route['route'],
				'template' => $route['route_template'],
				'pattern' => $route['route_pattern'],
				'parameters' => $route['parameters'],
				'constraints' => $route['constraints'],
			];
			$result = TRUE;
		} else {
			$result = FALSE;
		}

		return $result;
	}

	public function parseRoutes($routes, $parent_route) {
		$result = FALSE;
		foreach ($routes as $key => $current_route) {
//			route_breadcrumbs
			$this->chain[] = $key;
			$current_route = $this->normalizeRoute($current_route);
			$prepared_route = $this->prepareRoute($parent_route, $current_route);
			$route_result = $this->parseRoute($key, $prepared_route);
//			$route_result['route_breabcrumbs'][] = $key;
			if ($route_result !== FALSE) {
				if ($prepared_route['behaviour'] === 'next') {
					$result = $route_result;
//					$this->chain[] = $key;
//					echo $key;
//					$result['route']['breadcrumbs'][] = $key;
				} elseif ($prepared_route['behaviour'] === 'virtual') {
					$result = FALSE;
//					$this->chain[] = $key;
//					echo $key;
//					$result['route']['breadcrumbs'][] = $key;
				} elseif ($prepared_route['behaviour'] === 'break') {
					$result = $route_result;
//					$this->chain[$key][] = $key;
//					echo $key;
//					$result['route']['breadcrumbs'][] = $key;
					break;
				}
			} else {
//				array_pop($this->chain);
			}
			if (isset($current_route['children']) === TRUE) {
				$child_result = $this->parseRoutes($current_route['children'], $prepared_route);
				if ($child_result !== FALSE) {
//					echo $key;
//					$this->chain[$key][] = $key;
					$result = $child_result;
//					$result['route']['breadcrumbs'][] = $key;
					break;
				}
			} else {
				array_pop($this->chain);
			}
		}

		return $result;
	}

	/**
	 * @param $routes Map
	 *
	 * @return bool|mixed
	 */
	public function parse($routes) {
		$this->routes = $routes;
		$this->compare = \fa\core\faf::request()->path();
		$parent_route = $this->normalizeRoute(array());
		$result = $this->parseRoutes($routes::get(), $parent_route);
		/*
		 *
		 */
//		$a = $this->urlTo('/profile/sub/parameter/variable', [
//			'parameter' => 'FUCK',
//			'variable' => '123456',
//		]);
//		dump($a);
//		dump($this->url_to);
//		exit;
		return $result;
	}

	/*
	 * URL creation
	 */
	public function urlTo($key, $parameters = array()) {
		$this->url_to = [
			'template' => NULL,
			'constraints' => [],
		];
		$routes_map = $this->routes;
		$routes = $routes_map::get();
		$this->findUrlTo($key, $routes);
		if ($this->url_to['template'] !== NULL) {
			$result = $this->createUrlTo($parameters);
		} else {
			$result = $key;
		}

		return $result;
	}

	private function findUrlTo($key, $routes = NULL, $parent_key = NULL) {
		/**
		 * @var \fa\classes\Map $routes_map
		 */
//		echo '<hr/>LOOP START<hr/>';
		$result = FALSE;
		foreach ($routes as $route_key => $route_value) {
//			echo $key . '===' . $parent_key . $route_key . '<br/>';
			if ($key === $parent_key . $route_key) {
				$result = TRUE;
				$this->storeUrlTo($route_value);
				break;
			}
			if (isset($route_value['children']) === TRUE) {
				$result = $this->findUrlTo($key, $route_value['children'], $parent_key . $route_key);
			}
			if ($result === TRUE) {
				$this->storeUrlTo($route_value);
				break;
			};
		}

//		echo '<hr/>LOOP END<br/>';
		return $result;;
	}

	private function storeUrlTo($route) {
//		array_unshift($this->url_to['routes'], $route['route']);
//		dump($route);
		$this->url_to['template'] = $route['route'] . $this->url_to['template'];
		if (isset($route['constraints']) === TRUE) {
			$this->url_to['constraints'] = $this->url_to['constraints'] + $route['constraints'];
		}
//		dump($route);
//		$parameters = $this->getRouteParameters($route['route']);
//		dump($this->getRoutePattern($this->url_to['template']));
	}

	private function createUrlTo($parameters) {
		$route_parameters_map = array(
			'#\[#' => '',
			'#\]#' => '',
		);
		foreach ($this->url_to['constraints'] as $constraint_key => $constraint_value) {
			$map_key = "#:{$constraint_key}#";
//			$route_parameters_map[$map_key] = "{$this->url_to['constraints'][$constraint_key]}";
			$route_parameters_map[$map_key] = $parameters[$constraint_key];
		}
		$pattern = array_keys($route_parameters_map);
		$replacement = array_values($route_parameters_map);
		$result = preg_replace($pattern, $replacement, $this->url_to['template']);

		return $result;
	}
}
