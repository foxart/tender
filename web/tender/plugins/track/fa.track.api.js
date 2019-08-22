
(function (window, document, path, host, script, parser) {
	parser = document.createElement('a');
	parser.href = window.location.href;
	switch (parser.hostname) {
		case 'stopnet.comodo.od.ua':
			host = 'heat.comodo.od.ua';
			break;
		case 'stopnet.wo':
			host = 'heat.wo';
			break;
		default:
			return false;
	}
	window.heatApiUrl = '//' + host + '/' + path;
	window.heatApiKey = 'heatApiKey';
	script = document.createElement('script');
	script.async = 1;
	script.src = '//' + host + '/' + path;
	document.getElementsByTagName('head')[0].appendChild(script);
})(window, document, 'api/v1');

//(function (h, e, a, t, b, c, d) {
//	d = e.createElement('a');
//	d.href = h.location.href;
//	if (d.hostname === a || d.hostname === 'www.' + a) {
//		h.heatApiUrl = t;
//		h.heatApiKey = b;
//		c = e.createElement('script');
//		c.async = 1;
//		c.src = t;
//		e.getElementsByTagName('head')[0].appendChild(c);
//	}
//})(window, document, 'stopnet.wo', '//heat.wo/api/v1', 'heatApiKey');
