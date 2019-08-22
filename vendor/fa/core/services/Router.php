<?php

namespace fa\core\services;

use fa\core\classes\Singleton;
use fa\core\faf;

final class Router extends Singleton {

	public static $instance;
	public $request;
	public $ajax;
	public $route;
	public $matches;
	public $template;
	public $pattern;
	public $parameters;
	public $constraints;
	public $controller;
	public $action_before;
	public $action;
	public $action_after;
	public $arguments;
	public $trigger;
	/*
	 *  recheck
	 */
//	public $arguments;
//	public $debug;
	public $chain;
	public $url_to;
	public $routes;

	private function getRouteParameters($route) {
		/*
		 * route parameters map
		 */
		$route_parameters = NULL;
//		preg_match_all('#(?<=[:])[a-zA-Z0-9]+#', $route, $route_parameters);
		preg_match_all('/(?<=:)[^:\/\[\]]+/', $route, $route_parameters);
		if (count($route_parameters) === 0) {
			$result = FALSE;
		} else {
			$result = $route_parameters[0];
		}
//		if ($route==='/company/:company/bank'){
//			dump($route);
//			dump($route_parameters);
//			exit;
//		};
		return $result;
	}

	private function getRoutePattern($route, $route_parameters, $route_constraints) {
//		if ($route==='/company/:company/bank'){
//			dump($route);
//			dump($route_parameters);
//			dump($route_constraints);
//			exit;
//		};
		/* route pattern map */
		$route_parameters_map = array(
			'#\[#' => '(?:',
			'#\]#' => ')?',
		);
		foreach ($route_parameters as $item) {
			$key = "#:{$item}#";
			if (isset($route_constraints[$item]) === TRUE) {
				$route_parameters_map[$key] = "({$route_constraints[$item]})";
			} else {
				$route_parameters_map[$key] = '([^/]+)';
			}
		}
		/* route matches */
		$pattern = array_keys($route_parameters_map);
		$replacement = array_values($route_parameters_map);
		$result = preg_replace($pattern, $replacement, $route);

		return $result;
	}

	private function parseRouteLiteral($route) {
		$route_subject = $route['compare'];
		if ($route_subject === $route['template']) {
			$route_matches = array();
		} else {
			$route_matches = FALSE;
		}
		$result = $route_matches;

		return $result;
	}

	private function parseRouteSegment($route) {
		$route_subject = $route['compare'];
		$route_pattern = "#\\A{$route['pattern']}\\Z#";
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
//			'compare' => 'path',
			'behaviour' => 'break',
			'parameters' => array(),
			'constraints' => array(),
			'pattern' => NULL,
			'template' => NULL,
			'ajax' => NULL,
			'trigger' => array(),
//			'trigger' => array(
//				'controller' => 'controllerIndex',
//				'action_before' => array(),
//				'action' => 'actionIndex',
//				'action_after' => array(),
//				'arguments' => array(),
//			),
//			'chain' => array(
//				'controller' => 'controllerIndex',
//				'action_before' => array(),
//				'action' => 'actionIndex',
//				'action_after' => array(),
//				'arguments' => array(),
//			),
			'chain' => NULL,
		), $route);
	}

	private function prepareRoute($index, $route_parent, $route_current) {
//		var_dump($route_parent['parameters']);
//		var_dump($route_current['parameters']);
//		dump($route_current);
		$result = array();
		$route_current['parameters'] = $this->getRouteParameters($route_current['route']);
//		if ($route_current['compare'] === 'path') {
		$result['compare'] = $this->request['path'];
//		}
		if (isset($route_parent['route']) === FALSE) {
			$result['route'] = $route_current['route'];
		} else {
			$result['route'] = $route_parent['route'] . $route_current['route'];
		}
		if (isset($route_parent['index']) === FALSE) {
			$result['index'] = $index;
		} else {
			$result['index'] = $route_parent['index'] . $index;
		}
//		dump($route_current);
		$result['behaviour'] = $route_current['behaviour'];
//		$result['layout'] = $route_current['layout'];
		$result['ajax'] = $route_current['ajax'];
		$result['chain'] = $route_current['chain'];
		$result['trigger'] = $route_current['trigger'];
//		dump($route_current['ajax']);
//		$result['hmvc'] = array_replace($route_parent['hmvc'], $route_current['hmvc']);
//		$result['defaults'] = array_replace_recursive($route_parent['defaults'], $route_current['defaults']);
//		$result['route_breadcrumbs'][] = $current_route['route'];
		$result['template'] = $route_parent['template'] . $route_current['route'];
		$result['parameters'] = array_merge($route_parent['parameters'], $route_current['parameters']);
		if (count($this->getRouteParameters($route_current['route'])) > 0) {
			$result['constraints'] = array_replace($route_parent['constraints'], $route_current['constraints']);
			$result['pattern'] = $route_parent['pattern'] . $this->getRoutePattern($route_current['route'], $route_current['parameters'],
					$route_current['constraints']);
		} else {
			$result['constraints'] = $route_parent['constraints'];
			$result['pattern'] = $route_parent['pattern'] . $route_current['route'];
		}

//		var_dump($result['parameters']);
		return $result;
	}

	private function parseRoute($route) {
		if ($route['ajax'] !== NULL) {
			if ($route['ajax'] === $this->request['ajax']) {
				if (count($route['parameters']) > 0) {
					$route_matches = $this->parseRouteSegment($route);
				} else {
					$route_matches = $this->parseRouteLiteral($route);
				}
			} else {
				$route_matches = FALSE;
			}
		} else {
			if (count($route['parameters']) > 0) {
				$route_matches = $this->parseRouteSegment($route);
			} else {
				$route_matches = $this->parseRouteLiteral($route);
			}
		}
		if ($route_matches !== FALSE) {
			$this->template = $route['template'];
			$this->pattern = $route['pattern'];
			$this->parameters = $route['parameters'];
			$this->constraints = $route['constraints'];
			$this->route = $route['index'];
			$this->matches = $route_matches;
//			$this->controller = $route['defaults']['controller'];
			$this->trigger = $route['trigger'];
//			$this->action_before = $route['defaults']['action_before'];
//			$this->action = $route['defaults']['action'];
//			$this->action_after = $route['defaults']['action_after'];
//			$this->arguments = $route['defaults']['arguments'];
			$this->ajax = $route['ajax'];
			$this->chain = $route['chain'];
			$result = TRUE;
		} else {
			$result = FALSE;
		}

		return $result;
	}

	private function parseRoutes($routes, $parent_route) {
		$result = FALSE;
		foreach ($routes as $key => $current_route) {
//			route_breadcrumbs
			$current_route = $this->normalizeRoute($current_route);
			$prepared_route = $this->prepareRoute($key, $parent_route, $current_route);
			$route_result = $this->parseRoute($prepared_route);
//			$route_result['route_breabcrumbs'][] = $key;
			if ($route_result !== FALSE) {
				if ($prepared_route['behaviour'] === 'next') {
					$result = $route_result;
				} elseif ($prepared_route['behaviour'] === 'virtual') {
					/*
					 * todo-ivan виртуальный контроллер не накапливает данные
					 */
					$result = FALSE;
				} elseif ($prepared_route['behaviour'] === 'break') {
					$result = $route_result;
					break;
				}
			} else {
			}
			if (isset($current_route['children']) === TRUE) {
				$child_result = $this->parseRoutes($current_route['children'], $prepared_route);
				if ($child_result !== FALSE) {
					$result = $child_result;
					break;
				}
			} else {
			}
		}

		return $result;
	}

	/**
	 *
	 */
	/**
	 * @param $routes \fa\classes\Route
	 *
	 * @return bool|mixed
	 */
	public function parse($routes) {
		$this->routes = $routes;
		$this->request = [
			'path' => faf::request()->path(),
			'ajax' => faf::request()->isAjax,
		];
//		$this->compare = \fa\core\faf::request()->path();
		$parent_route = $this->normalizeRoute(array());
		$result = $this->parseRoutes($routes::get(), $parent_route);
		/*
		 *
		 */
//		dump($a);
//		dump($this->url_to);
//		exit;
		return $result;
	}

	/*
	 * URL creation
	 */
	public function urlTo($key, $parameters = array()) {
//		dump($parameters);
		$this->url_to = [
			'template' => NULL,
			'constraints' => [],
		];
		$routes_map = $this->routes;
		/*
		 * todo-ivan multiple calls of get, try to load routes once
		 */
		/**
		 * @var \fa\classes\Route $routes_map
		 */
		$routes = $routes_map::get();
		$this->findUrlTo($key, $routes);
		if ($this->url_to['template'] !== NULL) {
			$result = $this->createUrlTo($parameters);
		} else {
			throw new \Exception("route not found: {$key}");
//			$result = NULL;
		}

		return $result;
	}

	private function findUrlTo($key, $routes = NULL, $parent_key = NULL) {
		/**
		 * @var \fa\classes\Route $routes_map
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
		return $result;
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
		foreach ($parameters as $key => $value) {
			$map_key = "#:{$key}#";
//			$route_parameters_map[$map_key] = "{$this->url_to['constraints'][$constraint_key]}";
			$route_parameters_map[$map_key] = $parameters[$key];
		}
		$pattern = array_keys($route_parameters_map);
		$replacement = array_values($route_parameters_map);
		$string = $this->url_to['template'];
		$result = preg_replace($pattern, $replacement, $string);
		if ($result !== '/') {
			return rtrim($result, '/');
		} else {
			return $result;
		}
	}

	public function matches($key = NULL) {
		if ($key === NULL) {
			return $this->matches;
		} else {
			if (isset($this->matches[$key]) === TRUE) {
				return $this->matches[$key];
			} else {
				return NULL;
			}
		}
	}
}
