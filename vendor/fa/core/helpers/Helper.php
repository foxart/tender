<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;

final class Helper extends Singleton {

	public static $instance;
	public static $map = [
		'css' => 'text/css',
		'csv' => 'application/vnd.ms-excel',
		'html' => 'text/html',
		'ico' => 'image/vnd.microsoft.icon',
		'jpg' => 'image/jpeg',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'png' => 'image/png',
		'txt' => 'text/plain',
		'woff' => 'application/x-font-woff',
		'xml' => 'application/xml',
	];

	public function checkContentType($content_type) {
		return array_key_exists($content_type, array_flip(self::$map));
	}

	public function getExtensionByContentType($content_type) {
		if ($this->checkContentType($content_type) === TRUE) {
			$map = array_flip(self::$map);
			return $map[$content_type];
		} else {
			throw new \Exception('undefinded content type: ' . $content_type);
		}
	}

	public function checkExtension($extension) {
		return array_key_exists($extension, self::$map);
	}

	public function getContentTypeByExtension($extension) {
		if ($this->checkExtension($extension) === TRUE) {
			return self::$map[$extension];
		} else {
			throw new \Exception('undefinded extension: ' . $extension);
		}
	}

	public function getFilePermissions($file_path) {
		$result = array();
		$permissions = fileperms($file_path);
		switch ($permissions & 0xF000) {
			case 0xC000: // socket
				$info = 's';
				break;
			case 0xA000: // symbolic link
				$info = 'l';
				break;
			case 0x8000: // regular
				$info = 'r';
				break;
			case 0x6000: // block special
				$info = 'b';
				break;
			case 0x4000: // directory
				$info = 'd';
				break;
			case 0x2000: // character special
				$info = 'c';
				break;
			case 0x1000: // FIFO pipe
				$info = 'p';
				break;
			default: // unknown
				$info = 'u';
		}
// Owner
		$result['digit']['owner'] = $info . (($permissions & 0x0100) ? 'r' : '-') . (($permissions & 0x0080) ? 'w' : '-') . (($permissions & 0x0040) ? (($permissions & 0x0800) ? 's' : 'x') : (($permissions & 0x0800) ? 'S' : '-'));
// Group
		$result['digit']['group'] = $info . (($permissions & 0x0020) ? 'r' : '-') . (($permissions & 0x0010) ? 'w' : '-') . (($permissions & 0x0008) ? (($permissions & 0x0400) ? 's' : 'x') : (($permissions & 0x0400) ? 'S' : '-'));
// World
		$result['digit']['other'] = $info . (($permissions & 0x0004) ? 'r' : '-') . (($permissions & 0x0002) ? 'w' : '-') . (($permissions & 0x0001) ? (($permissions & 0x0200) ? 't' : 'x') : (($permissions & 0x0200) ? 'T' : '-'));
		$result['digit']['full'] = $result['digit']['owner'] . $result['digit']['group'] . $result['digit']['other'];
		$result['integer'] = fileperms($file_path);
		$result['octal'] = substr(sprintf('%o', fileperms($file_path)), -4);

		return $result;
	}

	public function getFileInfo($file_path) {
		$result = pathinfo($file_path);

		return [
			'directory' => $result['dirname'],
			'file' => $result['basename'],
			'name' => $result['filename'],
			'extension' => $result['extension'],
			'modification' => filemtime($file_path),
//			'permissions' => $this->getFilePermissions($file_path),
			'size' => filesize($file_path),
			'type' => filetype($file_path),
			'executeable' => is_executable($file_path),
			'readable' => is_readable($file_path),
			'writeable' => is_writeable($file_path),
		];
	}
}
