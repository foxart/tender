<?php
//set_error_handler('catch_error');
//
//register_shutdown_function('catch_fatal_error');
function get_trace($level = 0) {
	$debug_backtrace = debug_backtrace();
//	var_dump(debug_backtrace());
//	while ($level > 0) {
//		array_shift($debug_backtrace);
//		$level --;
//	}
//	$dump = array_reverse($debug_backtrace);
	$dump = $debug_backtrace;
	$i = 1;
	foreach ($dump as $item) {
		if (isset($item['file']) == TRUE) {
			$directory = dirname($item['file']) . DIRECTORY_SEPARATOR;
			$file = basename($item['file']);
		} else {
			$directory = NULL;
			$file = NULL;
		}
		if (isset($item['line']) == TRUE) {
			$line = $item['line'];
		} else {
			$line = NULL;
		}
		if (isset($item['function']) == TRUE) {
			$function = $item['function'];
		} else {
			$function = NULL;
		}
		if ($i & 1 == TRUE) {
			$style = 'padding: 6px; background-color: #F0F0F0;';
		} else {
			$style = 'padding: 6px; background-color: #C2C2C2;';
		}
		$subject = "<div style=\"{{ style }}\">{{ directory }}<b>{{ file }}</b>[{{ line }}] :: <b>{{ function }}()</b></div>";
		$search = array(
			'{{ style }}',
			'{{ directory }}',
			'{{ file }}',
			'{{ line }}',
			'{{ function }}',
		);
		$replace = array(
			$style,
			$directory,
			$file,
			$line,
			$function,
		);
		$chain = str_replace($search, $replace, $subject);
		$chain_array[] = $chain;
		$i++;
	}
	$result = implode('', $chain_array);

	return $result;
}

function format_error($error_number, $error_string, $error_file, $error_line, array $error_context = NULL) {
//	view($error_context);
	$trace = get_trace();
	ob_start();
	echo "<div style=\"display: block; margin: 0px; padding: 6px 0px 6px 0px; font-size: 18px; line-height: 18px; font-weight: bold; text-transform: uppercase;\">error</div>";
	echo "<table style=\"width: 100%;\">";
	echo "<tr><td style=\"width: 25%; word-break: keep-all;\"><b>message</b></td><td style=\"width: 75%;\">{$error_string}</td></tr>";
	echo "<tr><td><b>number</b></td><td>{$error_number}</td></tr>";
	echo "<tr><td><b>file</b></td><td>{$error_file}</td></tr>";
	echo "<tr><td><b>line</b></td><td>{$error_line}</td></tr>";
	echo "<tr><td style=\"vertical-align: top;\"><b>context</b></td><td>";
	var_dump($error_context);
	echo "</td></tr>";
	echo "</table>";
	echo "<div style=\"display: block; margin: 0px; padding: 12px 0px 6px 0px; font-size: 14px; line-height: 14px; font-weight: bold; text-transform: uppercase;\">trace</div>";
	echo $trace;
	$result = ob_get_clean();

	return $result;
}

function catch_error($error_number, $error_string, $error_file, $error_line, array $error_context) {
	if (error_reporting() === 0) {
		return FALSE;
	}
	/*
	  // ignore error that was suppressed with the @-operator
	  if (0 === error_reporting()) {
	  return false;
	  }
	 */
	if (headers_sent() === FALSE) {
		header('HTTP/1.0 500 Internal Server Error');
		header('Content-Type: text/html');
	}
	$result = wrap_output(format_error($error_number, $error_string, $error_file, $error_line, $error_context));
	echo $result;
	exit;
}

function catch_fatal_error() {
	if (error_reporting() === 0) {
		return FALSE;
	}
	$error = error_get_last();
	if ($error !== NULL) {
		if (headers_sent() === FALSE) {
			header('HTTP/1.0 500 Internal Server Error');
			header('Content-Type: text/html');
		}
		$result = wrap_output(format_error(E_ERROR, $error['message'], $error['file'], $error['line']));
		echo $result;
		exit;
	}
}

//function raise_error($error) {
//	throw new \Exception($error, E_USER_ERROR);
//	exit;
//}
