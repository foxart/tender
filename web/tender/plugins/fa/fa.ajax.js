/**
 * foxart.org
 * ajax
 */

if ($fa.ajax === undefined) {
	$fa.fn = $fa.ajax = {
		xhr: function () {
			if (typeof XMLHttpRequest !== 'undefined') {
				return new XMLHttpRequest();
			}
			var versions = [
				"MSXML2.XmlHttp.6.0",
				"MSXML2.XmlHttp.5.0",
				"MSXML2.XmlHttp.4.0",
				"MSXML2.XmlHttp.3.0",
				"MSXML2.XmlHttp.2.0",
				"Microsoft.XmlHttp"
			];
			var $xhr;
			for (var i = 0; i < versions.length; i++) {
				try {
					$xhr = new ActiveXObject(versions[i]);
					break;
				} catch (e) {
				}
			}
			return $xhr;
		},
		serialize: function (object, prefix) {
			var str = [];
			for (var p in object) {
				if (object.hasOwnProperty(p)) {
					var k = prefix ? prefix + "[" + p + "]" : p, v = object[p];
					str.push(typeof v === "object" ? $fa.ajax.serialize(v, k) : encodeURIComponent(k) + "=" + encodeURIComponent(v));
				}
			}
			return str.join("&");
		},
		send: function (url, method, data, async, callback) {
			var $xhr = $fa.ajax.xhr();
			var state = [
				'Unitialized',
				'Loading',
				'Loaded',
				'Interactive',
				'Complete'
			];
			// 0 - Unitialized
			// 1 - Loading
			// 2 - Loaded
			// 3 - Interactive
			// 4 - Complete
			$xhr.onreadystatechange = function () {
				// $fa.console.info('fa()->ajax(' + url + ')', state[$xhr.readyState]);
				if ($xhr.readyState === 4) {
					if (callback !== undefined) {
						callback($xhr);
					}
				}
			};
			if (async === undefined) {
				async = true;
			}
			data = $fa.ajax.serialize(data);
			if (method === 'get') {
				url = url + (data.length ? '?' + data : '');
				data = null;
			}

			$xhr.open(method, url, async);
			$xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			if (method === 'post') {
				$xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			}
			$xhr.send(data);
		}
	};
}
