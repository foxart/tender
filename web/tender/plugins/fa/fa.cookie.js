
/*
 * foxart.org
 * fa.cookie.js
 */
if ($fa.cookie === undefined) {
	$fa.fn = $fa.cookie = {
		get: function (name) {
			var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
			return matches ? decodeURIComponent(matches[1]) : undefined;
		},
		set: function (name, value, options) {
			options = options || {};
			if (options.path === undefined) {
				options.path = '/';
			}
			var expires = options.expires;
			if (typeof expires === 'number' && expires) {
				var d = new Date();
				d.setTime(d.getTime() + expires * 1000);
				expires = options.expires = d;
			}
			if (expires && expires.toUTCString) {
				options.expires = expires.toUTCString();
			}
			value = encodeURIComponent(value);
			var updatedCookie = name + '=' + value;
			for (var propName in options) {
				updatedCookie += ';' + propName;
				var propValue = options[propName];
				if (propValue !== true) {
					updatedCookie += '=' + propValue;
				}
			}
			document.cookie = updatedCookie;
		},
		delete: function (name, options) {
			options = options || {};
			if (options.path === undefined) {
				options.path = '/';
			}
			options.expires = -1;
			$fa.cookie.set(name, '', options);
		}
	};
}