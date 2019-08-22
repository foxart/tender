<?php

namespace fa\core\services;

final class Server extends \fa\core\classes\Singleton {

	/**
	 * @var static <p>reference to the <i>Singleton</i> instance of class</p>
	 */
	public static $instance;

	public function getIp() {
// check for shared internet/ISP IP
		if (!empty($_SERVER['HTTP_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}
// check for IPs passing through proxies
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
// check if multiple ips exist in var
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== FALSE) {
				$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($iplist as $ip) {
					if (self::validateIp($ip)) {
						return $ip;
					}
				}
			} else {
				if (self::validateIp($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
				}
			}
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && self::validateIp($_SERVER['HTTP_X_FORWARDED'])) {
			return $_SERVER['HTTP_X_FORWARDED'];
		}
		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		}
		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && self::validateIp($_SERVER['HTTP_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_FORWARDED_FOR'];
		}
		if (!empty($_SERVER['HTTP_FORWARDED']) && self::validateIp($_SERVER['HTTP_FORWARDED'])) {
			return $_SERVER['HTTP_FORWARDED'];
		}

// return unreliable ip since all else failed
		return $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * Parses a user agent string into its important parts
	 *
	 * @author Jesse G. Donat <donatj@gmail.com>
	 * @link https://github.com/donatj/PhpUserAgent
	 * @link http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
	 *
	 * @param string|NULL $agent User agent string to parse or NULL. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
	 *
	 * @throws InvalidArgumentException on not having a proper user agent to parse.
	 * @return string[] an array with browser, version and platform keys
	 */
	public function getAgent($agent = NULL) {
		if ($agent === NULL) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		$platform = NULL;
		$browser = NULL;
		$version = NULL;
		$empty = array(
			'platform' => $platform,
			'browser' => $browser,
			'version' => $version,
		);
		if (!$agent) {
			return $empty;
		}
		if (preg_match('/\((.*?)\)/im', $agent, $parent_matches)) {
			preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
				(?:\ [^;]*)?
				(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
			$priority = array(
				'Xbox One',
				'Xbox',
				'Windows Phone',
				'Tizen',
				'Android',
				'CrOS',
				'Linux',
				'X11',
			);
			$result['platform'] = array_unique($result['platform']);
			if (count($result['platform']) > 1) {
				if ($keys = array_intersect($priority, $result['platform'])) {
					$platform = reset($keys);
				} else {
					$platform = $result['platform'][0];
				}
			} elseif (isset($result['platform'][0])) {
				$platform = $result['platform'][0];
			}
		}
		if ($platform == 'linux-gnu' || $platform == 'X11') {
			$platform = 'Linux';
		} elseif ($platform == 'CrOS') {
			$platform = 'Chrome OS';
		}
		preg_match_all('%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
				Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|
				Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
				Valve\ Steam\ Tenfoot|
				NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
				(?:\)?;?)
				(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix', $agent, $result, PREG_PATTERN_ORDER);
// If nothing matched, return NULL (to avoid undefined index errors)
		if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
			if (preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $agent, $result)) {
				return array(
					'platform' => $platform ?: NULL,
					'browser' => $result['browser'],
					'version' => isset($result['version']) ? $result['version'] ?: NULL : NULL,
				);
			}

			return $empty;
		}
		if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $agent, $rv_result)) {
			$rv_result = $rv_result['version'];
		}
		$browser = $result['browser'][0];
		$version = $result['version'][0];
		$lowerBrowser = array_map('strtolower', $result['browser']);
		$find = function ($search, &$key) use ($lowerBrowser) {
			$xkey = array_search(strtolower($search), $lowerBrowser);
			if ($xkey !== FALSE) {
				$key = $xkey;

				return TRUE;
			}

			return FALSE;
		};
		$key = 0;
		$ekey = 0;
		if ($browser == 'Iceweasel') {
			$browser = 'Firefox';
		} elseif ($find('Playstation Vita', $key)) {
			$platform = 'PlayStation Vita';
			$browser = 'Browser';
		} elseif ($find('Kindle Fire', $key) || $find('Silk', $key)) {
			$browser = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
			$platform = 'Kindle Fire';
			if (!($version = $result['version'][$key]) || !is_numeric($version[0])) {
				$version = $result['version'][array_search('Version', $result['browser'])];
			}
		} elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
			$browser = 'NintendoBrowser';
			$version = $result['version'][$key];
		} elseif ($find('Kindle', $key)) {
			$browser = $result['browser'][$key];
			$platform = 'Kindle';
			$version = $result['version'][$key];
		} elseif ($find('OPR', $key)) {
			$browser = 'Opera Next';
			$version = $result['version'][$key];
		} elseif ($find('Opera', $key)) {
			$browser = 'Opera';
			$find('Version', $key);
			$version = $result['version'][$key];
		} elseif ($find('Midori', $key)) {
			$browser = 'Midori';
			$version = $result['version'][$key];
		} elseif ($browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $ekey)) {
			$browser = 'MSIE';
			if ($find('IEMobile', $key)) {
				$browser = 'IEMobile';
				$version = $result['version'][$key];
			} elseif ($ekey) {
				$version = $result['version'][$ekey];
			} else {
				$version = $rv_result ?: $result['version'][$key];
			}
			if (version_compare($version, '12', '>=')) {
				$browser = 'Edge';
			}
		} elseif ($find('Vivaldi', $key)) {
			$browser = 'Vivaldi';
			$version = $result['version'][$key];
		} elseif ($find('Valve Steam Tenfoot', $key)) {
			$browser = 'Valve Steam Tenfoot';
			$version = $result['version'][$key];
		} elseif ($find('Chrome', $key) || $find('CriOS', $key)) {
			$browser = 'Chrome';
			$version = $result['version'][$key];
		} elseif ($browser == 'AppleWebKit') {
			if (($platform == 'Android' && !($key = 0))) {
				$browser = 'Android Browser';
			} elseif (strpos($platform, 'BB') === 0) {
				$browser = 'BlackBerry Browser';
				$platform = 'BlackBerry';
			} elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
				$browser = 'BlackBerry Browser';
			} elseif ($find('Safari', $key)) {
				$browser = 'Safari';
			} elseif ($find('TizenBrowser', $key)) {
				$browser = 'TizenBrowser';
			}
			$find('Version', $key);
			$version = $result['version'][$key];
		} elseif ($key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser']))) {
			$key = reset($key);
			$platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
			$browser = 'NetFront';
		}
		$result = array(
			'platform' => $platform ?: NULL,
			'browser' => $browser ?: NULL,
			'version' => $version ?: NULL,
		);

		return $result;
	}

	public function parseUrl($url = NULL) {
		$url_parsed = parse_url($url);
		if (isset($url_parsed['scheme']) === TRUE and isset($url_parsed['host']) === TRUE and isset($url_parsed['path']) === TRUE) {
			$result = array(
				'scheme' => $url_parsed['scheme'],
				'host' => preg_replace('#^www\.(.+\.)#i', '$1', $url_parsed['host']),
				'path' => $url_parsed['path'],
			);
		} else {
			$result = array(
				'scheme' => NULL,
				'host' => NULL,
				'path' => NULL,
			);
		}

		return $result;
	}
}
