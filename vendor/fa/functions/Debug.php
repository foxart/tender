<?php
function wrap_output($content) {
	$result = "";
	$result .= "<div style=\"display: table; width: 100%; margin: 0px; padding: 0px; background-color: #CFCFCF;\">";
	$result .= "<div style=\"display: block; margin: 6px; padding: 6px; background-color: #FFFFFF; border: solid 1px black;\">";
	$result .= "<div style=\"display: block; margin: 0px; padding: 0px; color: black; font-weight: normal; word-break: break-all; white-space: pre-wrap;\">";
	$result .= $content;
	$result .= "</div>";
	$result .= "</div>";
	$result .= "</div>";

	return $result;
}

function format_print($content) {
	ob_start();
	var_dump($content);
	$buffer = ob_get_clean();
//	$result = htmlentities($buffer);
	$result = $buffer;

	return $result;
}

function view_constants() {
	$constants = get_defined_constants(TRUE);
	view($constants['user']);
}

function view($content = NULL, $output = TRUE) {
	if (headers_sent() === FALSE) {
		header('Content-Type: text/html');
	}
	$result = wrap_output("<div style=\"display: block; margin: 0px; padding: 0px 0px 6px 0px; font-size: 1.2em; line-height: 1.2em; font-weight: bold; text-transform: uppercase;\">view</div>" . format_print($content) . "<div  style=\"display: block; margin: 0px; padding: 6px 0px 6px 0px; font-size: 1.1em; line-height: 1.1em; font-weight: bold; text-transform: uppercase;\">trace</div>" . get_trace());
//	$result = wrap_output(format_print($content) . get_trace());
	if ($output === TRUE) {
		echo $result;
	} else {
		return $result;
	}
}
