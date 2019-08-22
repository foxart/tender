
/*
 * foxart.org
 * fa.parse.js
 */
if ($fa.parse === undefined) {
	$fa.fn = $fa.parse = {
		ajax: function ($xhr) {
			var $result;
			if ($xhr.status !== 200) {
				$fa.console.error('fa', 'AJAX parse error [' + $xhr.status + ' ' + $xhr.statusText + ']');
				$fa.debug.log('fa -> parse -> ajax -> error');
				$fa.debug.log($xhr.responseText);
				console.log($xhr.responseText);
				$result = null;
			} else {
				$result = $xhr.responseText;
			}
			return $result;
		},
		json: function ($json) {
			var $result;
			try {
				$result = JSON.parse($json);
			} catch (error) {
				$fa.console.error('fa', 'JSON parse error');
				$fa.debug.log('fa -> parse -> json -> error');
				$fa.debug.log($json);
				$result = null;
			}
			return $result;
		},
		url: function ($url) {
			var $parser = document.createElement('a'), $searchObject = {}, $queries, $split, $count;
			// Let the browser do the work
			$parser.href = $url;
			// Convert query string to object
			$queries = $parser.search.replace(/^\?/, '').split('&');
			for ($count = 0; $count < $queries.length; $count++) {
				$split = $queries[$count].split('=');
				$searchObject[$split[0]] = $split[1];
			}
			return {
				protocol: $parser.protocol + '//',
				host: $parser.host,
				hostname: $parser.hostname,
				port: $parser.port,
				pathname: $parser.pathname,
				search: $parser.search,
				searchObject: $searchObject,
				hash: $parser.hash
			};
		}
	};
}
