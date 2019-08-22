/*
 * foxart.org
 * fa.js
 */
if ($fa.get === undefined) {
	$fa.fn = $fa.get = {
		windowInnerSize: function () {
			return {
				width: document.documentElement.clientWidth,
				height: document.documentElement.clientHeight
			};
		},
		windowOuterSize: function () {
			return {
				width: window.outerWidth,
				height: window.outerHeight
			};
		},
		windowSize: function () {
			return {
				width: window.innerWidth,
				height: window.innerHeight
			};
		},
		documentSize: function () {
			return {
				width: Math.max(document.body.scrollWidth, document.documentElement.scrollWidth),
				height: Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
			};
		},
		scroll: function () {
			return {
				left: window.pageXOffset,
				top: window.pageYOffset
			};
		},
		mouse: function (event) {
			var $result = {
				x: null,
				y: null
			};
			if ($fa.check.ie() !== false) {
				var $scroll = $fa.get.scroll();
				$result.x = event.clientX + $scroll.left;
				$result.y = event.clientY + $scroll.top;
			} else {
				$result.x = event.pageX;
				$result.y = event.pageY;
			}
			return $result;
		}
	};
}
