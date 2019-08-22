
/*
 * foxart.org
 * fa.console.js
 */

if ($fa.console === undefined) {
	$fa.fn = $fa.console = {
		css: {
			log: "margin: 0px; padding: 1px 3px; color: #FFF; background-color: #808080;",
			info: "margin: 0px; padding: 1px 3px; color: #FFF; background-color: #0000FF;",
			warn: "margin: 0px; padding: 1px 3px; color: #FFF; background-color: #FFA500;",
			error: "margin: 0px; padding: 1px 3px; color: #FFF; background-color: #FF0000;",
			text: "margin: 0px; padding: 1px 3px; color: #000; background-color: #FFFFFF;"
		},
		log: function ($key, $value) {
			if ($value === undefined)
			{
				this.console('log', $key, this.css.log, this.css.text);
			} else {
				this.console($key, $value, this.css.log, this.css.text);
			}
		},
		info: function ($key, $value) {
			if ($value === undefined)
			{
				this.console('information', $key, this.css.info, this.css.text);
			} else {
				this.console($key, $value, this.css.info, this.css.text);
			}
		},
		warn: function ($key, $value) {
			if ($value === undefined)
			{
				this.console('warning', $key, this.css.warn, this.css.text);
			} else {
				this.console($key, $value, this.css.warn, this.css.text);
			}
		},
		error: function ($key, $value) {
			if ($value === undefined)
			{
				this.console('error', $key, this.css.error, this.css.text);
			} else {
				this.console($key, $value, this.css.error, this.css.text);
			}
		},
		console: function ($key, $value, $key_style, $value_style) {
			console.log('%c' + $key + '%c' + $value, $key_style, $value_style);
		},
		test: function () {
			this.log('key');
			this.info('key');
			this.warn('key');
			this.error('key');
		}
	};
//$fa.console.test();
}
