/*
 * foxart.org
 * fa.js
 */
if ($fa === undefined) {
	var $fa = function (selector, context) {
		return new $fa.fn.init(selector, context);
	};
//$fa.fn = $fa.prototype = {};
	$fa.fn = $fa.dom = {
		metadata: function ($dom, $attribute) {
			var $pattern = /({.*})/;
			var $metadata;
			var $result;
			if ($attribute === undefined) {
				$attribute = 'class';
			}
			try {
				$metadata = $pattern.exec($dom.getAttribute($attribute));
				if ($.type($metadata) === 'array') {
					$result = eval("(" + $metadata[1] + ")");
				}
			} catch ($error) {
				$result = undefined;
				console.error($error);
			}
			return $result;
		}
	};

	$fa.fn = $fa.execute = {
		function: function (name, context /*, args */) {
			if (context === undefined) {
				context = window;
			}
			var args = Array.prototype.slice.call(arguments, 2);
			var namespaces = name.split(".");
			var func = namespaces.pop();
			for (var i = 0; i < namespaces.length; i++) {
				context = context[namespaces[i]];
			}
			return context[func].apply(context, args);
		}
	};

	//
	$fa.fn = $fa.string = {
		capitalize: function ($string) {
			return $string.charAt(0).toUpperCase() + $string.slice(1);
		}
	};
	$fa.fn = $fa.check = {
		dom: function (element) {
			if (element === undefined) {
				return false;
			} else {
				return true;
			}
		},
		iframe: function () {
			try {
				return window.self !== window.top;
			} catch (e) {
				return true;
			}
		},
		ie: function () {
			var ua = window.navigator.userAgent;
			// IE 10
			// ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
			// IE 11
			// ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
			// Edge 12 (Spartan)
			// ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';
			// Edge 13
			// ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';
			var msie = ua.indexOf('MSIE ');
			if (msie > 0) {
				// IE 10 or older => return version number
				return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
			}
			var trident = ua.indexOf('Trident/');
			if (trident > 0) {
				// IE 11 => return version number
				var rv = ua.indexOf('rv:');
				return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
			}
			var edge = ua.indexOf('Edge/');
			if (edge > 0) {
				// Edge (IE 12+) => return version number
				return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
			}
			// other browser
			return false;
		}
	};
}
