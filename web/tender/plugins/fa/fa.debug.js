
/*
 * foxart.org
 * fa.debug.js
 */
if ($fa.debug === undefined) {
	$fa.fn = $fa.debug = {
//	("beforebegin", "afterbegin", "beforeend", "afterend")
		$debug_height: window.innerHeight - 24,
		element: {
			debug: 'fa_debug',
			container: 'fa_debug_output',
			button_exit: 'fa_debug_exit',
			button_clear: 'fa_debug_clear'
		},
		css: {
			debug: 'position: fixed; display: block; width: 25%; height: 100%; top: 0px; right: 0px; font-size: 11px; line-height: 11px; font-family: Comic Sans MS; background-color: #000000; opacity: 0.9; z-index: 16777271;',
			container: 'display: block; overflow: auto; margin: 6px 0px 6px 0px; padding: 0px 6px 0px 6px; color: #FFFFFF;',
			button_exit: 'position: absolute; display: block; top: 0px; right: 0px; margin: 6px; padding: 3px 6px; text-decoration: none; color: #000000; background-color: #FFFFFF; border: solid 1px grey; border-radius: 3px; z-index: 16777271;',
			button_clear: 'position: absolute; display: block; bottom: 0px; right: 0px; margin: 6px; padding: 3px 6px; text-decoration: none; color: #000000; background-color: #FFFFFF; border: solid 1px grey; border-radius: 3px; z-index: 16777271;'
		},
		create: function () {
			if (this.created !== undefined) {
				console.error('fa debug alredy created');
				return false;
			}
//			document.body.innerHTML += '<div id="' + this.element.debug + '" style="' + this.css.debug + '"></div>';
			document.body.insertAdjacentHTML('beforeend', '<div id="' + this.element.debug + '" style="' + this.css.debug + '"></div>');
			document.getElementById(this.element.debug).insertAdjacentHTML('beforeend', '<div id="' + this.element.container + '" style="' + this.css.container + ' height: ' + this.$debug_height + 'px;"></div>');
			document.getElementById(this.element.debug).insertAdjacentHTML('beforeend', '<a id="' + this.element.button_clear + '" style="' + this.css.button_clear + '" href="#">clear</a>');
			document.getElementById(this.element.debug).insertAdjacentHTML('beforeend', '<a id="' + this.element.button_exit + '" style="' + this.css.button_exit + '" href="#">exit</a>');
			this.container = this.element.debug;
			this.output = this.element.container;
			document.querySelector('body').addEventListener('click', $fa.debug.handle_exit, false);
			document.querySelector('body').addEventListener('click', $fa.debug.handle_clear, false);
		},
		log: function ($text) {
			var $output;
			$output = document.getElementById(this.output);
			if ($output !== undefined && $output !== null) {
				$output.insertAdjacentHTML('beforeend', '<div style="margin-bottom: 10px; font-size: 10px; font-style: italic; color: gray;">' + Date.now() + '</div>');
				$output.insertAdjacentHTML('beforeend', '<div style="margin-bottom: 10px;">' + $text + '</div>');
				$output.scrollTop = $output.scrollHeight;
			}
		},
		clear: function () {
			var $output;
			$output = document.getElementById(this.output);
			if ($output !== undefined && $output !== null) {
				$output.innerHTML = "";
			}
		},
		handle_exit: function (event) {
			if (event.target.id === $fa.debug.element.button_exit) {
				document.body.removeEventListener('click', $fa.debug.handle_clear, false);
				document.body.removeEventListener('click', $fa.debug.handle_exit, false);
				document.getElementById($fa.debug.element.debug).parentNode.removeChild(document.getElementById($fa.debug.element.debug));
				$fa.cookie.delete('fa_debug');
				event.preventDefault();
			}
		},
		handle_clear: function (event) {
			if (event.target.id === $fa.debug.element.button_clear) {
				$fa.debug.clear();
				event.preventDefault();
			}
		}
	};

	if ($fa.check.iframe() === false)
	{
		window.addEventListener('load', function () {
			var $url;
			$url = $fa.parse.url(window.location.href);
			if (typeof ($url.searchObject.fa_debug) !== 'undefined') {
				if ($url.searchObject.fa_debug === '1') {
					$fa.cookie.set('fa_debug', 1);
				} else if ($url.searchObject.fa_debug === '0') {
					$fa.cookie.delete('fa_debug');
					console.log($fa.cookie.get('fa_debug'));
				}
			}
			if ($fa.cookie.get('fa_debug') !== undefined) {
				$fa.debug.create();
			}
		});
	}
}