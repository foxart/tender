/* IE8 compability part - begin */
(function (fn) {
	if (!fn.map)
		fn.map = function (f) {
			var r = [];
			for (var i = 0; i < this.length; i++)
				r.push(f(this[i]));
			return r
		}
	if (!fn.filter)
		fn.filter = function (f) {
			var r = [];
			for (var i = 0; i < this.length; i++)
				if (f(this[i]))
					r.push(this[i]);
			return r
		}
})(Array.prototype);
if (!Object.prototype.hasOwnProperty) {
	Object.prototype.hasOwnProperty = function (prop) {
		var proto = this.__proto__ || this.constructor.prototype;
		return (prop in this) && (!(prop in proto) || proto[prop] !== this[prop]);
	};
}
if (typeof String.prototype.trim !== 'function')
{
	String.prototype.trim = function ()
	{
		return this.replace(/^\s+|\s+$/g, '');
	}
}
Object.keys = Object.keys || function (o) {
	var result = [];
	for (var name in o) {
		if (o.hasOwnProperty(name))
			result.push(name);
	}
	return result;
};
/* IE8 compability part - end */
var NTM;
$(document).ready(function ()
{
	NTM =
			{
				version: 4000,
				track: '',
				serviceURL: '/extension/vtiger/ntm.php',
				pixelURL: '/extension/vtiger/images/pixel.track2',
				cookies: {},
				urlParams: {},
				keys: {
					'key1': {},
					'key2': {},
					'key4': {},
					'key5': {},
					'key6': {},
					'key7': {},
					'key8': {}
				},
				last_pointers: {
					'key1': 0,
					'key2': 0,
					'key4': 0,
					'key5': 0,
					'key6': 0,
					'key7': 0,
					'key8': 0
				},
				hasUrlParameter: false,
				initialVisit: false,
				cookieDomain: '',
				start: function ()
				{
					NTM.Utils.Url.getUrlParams();
					NTM.cookieDomain = NTM.Utils.Cookie.getDomainForCookie(NTM.Utils.Url.parseUrl(document.URL, 'host'));
					NTM.getTrackVal();
					NTM.Utils.Cookie.getCookies();
					var tmpUrl = NTM.Utils.Url.urlComp(document.URL);
					var pageID = NTM.getPageID(tmpUrl[0]);
					NTM.setKey(7, 0, encodeURIComponent(document.URL));
					NTM.setKey(7, 1, pageID);
					NTM.setKey(5, 0, NTM.track == undefined ? '' : NTM.track);
					if (NTM.getKey(5, 1) == '') // key5sk1 is not exist in URL, totally new visit. Populate yellow parameters to pass them to pixel
					{
						NTM.initialVisit = true;
						NTM.setKey6Parameters();
						$.ajax({url: NTM.serviceURL, type: 'POST', dataType: 'text', data: 'usf=getSHA', async: false, cache: false, success: function (data) {
								NTM.setKey(5, 1, data);
							}});
						NTM.checkKeywords();
						NTM.checkChannel();
					}
					$('a').each(function ()
					{
						var tmp = $(this).attr('href');
						var tmp2 = $(this).attr('class');
						if (tmp != undefined && tmp2 != 'addthis')
						{
							if (!tmp.match(/facebook\.com\//i) && !tmp.match(/\.swf$/i) && !tmp.match(/\.flv/gi)
									&& !tmp.match(/liveperson\.net/i) && !tmp.match(/addthis\.com/ig) && !tmp.match(/matousec\.com/i)
									&& !tmp.match(/cert.webtrust\.org\//i) && !tmp.match(/mailto:/i) && !tmp.match(/http:\/\/www.comodo.cn/i)
									&& !tmp.match(/http:\/\/www.comodojapan.com/i) && !tmp.match(/http:\/\/www.comodoisrael.com/i) && !tmp.match(/http:\/\/www.comodogroup.it/i)
									&& !tmp.match(/products\/frontpage/i) && !tmp.match(/javascript:/i) && !tmp.match(/\#/i)
									&& !tmp.match(/twitter/i) && !tmp.match(/download.cnet.com/i) && !tmp.match(/support\.comodo\.com/i) && !tmp.match(/secure\.comodo\.com\/products\/publiclyDisclosedSubCACerts/i))
							{
								var par = NTM.Utils.Url.parametersToString(tmp);
								if (par.length > 0)
								{
									if (!tmp.match(/\.php\?/ig) && !tmp.match(/\.html\?/ig) && !tmp.match(/\.htm\?/ig) && !tmp.match(/\?/ig))
									{
										tmp += '?' + par;
									} else
									{
										tmp = tmp.substr(0, tmp.indexOf('?') + 1) + par;
									}
								}
								$(this).attr('href', tmp);
							}
						}
					});
				},
				getTrackVal: function ()
				{
					if (NTM.urlParams.hasOwnProperty('track') && NTM.urlParams.track == parseInt(NTM.urlParams.track))
					{
						NTM.track = NTM.urlParams.track;
					} else
					{
						var t = $("#track");
						NTM.track = t.html();
						t.remove();
					}
					if (NTM.track == undefined)
					{
						NTM.track = '';
					}
					if (NTM.track == '')
					{
						if (typeof (NTM.keys.key5.sk0) != 'undefined' && NTM.keys.key5.sk0 != '')
						{
							NTM.track = NTM.keys.key5.sk0;
						}
					}
				},
				Utils:
						{
							Url:
									{
										parseUrl: function (str, component)
										{
											var key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port',
												'relative', 'path', 'directory', 'file', 'query', 'fragment'],
													ini = (this.php_js && this.php_js.ini) || {},
													mode = (ini['phpjs.parse_url.mode'] &&
															ini['phpjs.parse_url.mode'].local_value) || 'php',
													parser = {
														php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
														strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
														loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-scheme to catch file:/// (should restrict this)
													};
											var m = parser[mode].exec(str),
													uri = {},
													i = 14;
											while (i--)
											{
												if (m[i])
												{
													uri[key[i]] = m[i];
												}
											}
											if (component)
											{
												return uri[component.replace('PHP_URL_', '').toLowerCase()];
											}
											if (mode !== 'php')
											{
												var name = (ini['phpjs.parse_url.queryKey'] &&
														ini['phpjs.parse_url.queryKey'].local_value) || 'queryKey';
												parser = /(?:^|&)([^&=]*)=?([^&]*)/g;
												uri[name] = {};
												uri[key[12]].replace(parser, function ($0, $1, $2)
												{
													if ($1)
													{
														uri[name][$1] = $2;
													}
												});
											}
											delete uri.source;
											return uri;
										},
										getReferrer: function ()
										{
											if (document.referrer != '')
											{
												var host = NTM.Utils.Url.parseUrl(document.referrer, 'host');
												if (host.match(/google/i))
												{
													var referrer = 'Google';
												} else if (host.match(/yahoo/i))
												{
													var referrer = 'Yahoo';
												} else if (host.match(/bing/i))
												{
													var referrer = 'Bing';
												} else if (document.URL.indexOf('?', 0) != -1)
												{
													var referrer = document.URL.substr(0, document.URL.indexOf('?', 0));
												} else
												{
													var referrer = document.URL;
												}
											} else
											{
												if (document.URL.indexOf('?', 0) != -1)
												{
													var referrer = document.URL.substr(0, document.URL.indexOf('?', 0));
												} else
												{
													var referrer = document.URL;
												}
											}
											return encodeURIComponent(referrer);
										},
										urlComp: function (url)
										{
											var tmp = [];
											if (url.indexOf('?', 0) != -1)
											{
												tmp[0] = url.substring(0, url.indexOf('?', 0));
												tmp[1] = url.substring(url.indexOf('?', 0) + 1, url.length);
											} else
											{
												tmp[0] = url;
											}
											return tmp;
										},
										parametersToString: function (tmp)
										{
											var pars = {};
											for (var key in NTM.urlParams)
											{
												if (NTM.urlParams[key] != '')
												{
													pars[key] = NTM.urlParams[key];
												}
											}
											var obj = NTM.Utils.Url.combine(tmp);
											for (var key in obj)
											{
												pars[key] = obj[key];
											}
											for (var key in NTM.keys)
											{
												if (key == 'key5')
												{
													for (var subkey in NTM.keys[key])
													{
														if (subkey == 'sk0' || subkey == 'sk1')
														{
															if (NTM.keys[key][subkey] != '')
															{
																pars[key + subkey] = NTM.keys[key][subkey];
															}
														}
													}
												}
											}
											var str = [];
											for (var i in pars)
											{
												str.push(i + '=' + pars[i]);
											}
											return str.join('&');
										},
										combine: function (url)
										{
											var pos = url.indexOf('?');
											var pairs = {};
											if (pos != -1)
											{
												var parts = url.substring(pos + 1).split('&');
												if (parts.length > 0)
												{
													parts.map(function (i)
													{
														var s = i.split('=');
														if (s.length == 2)
														{
															var s0 = NTM.Utils.Url.escape(s[0]);
															if (s0.length > 0)
															{
																pairs[s[0]] = NTM.Utils.Url.escape(s[1]);
															}
														}
													});
												}
											}
											return pairs;
										},
										getUrlParams: function ()
										{
											NTM.urlParams = {};
											var pos = document.URL.indexOf('?');
											if (pos != -1)
											{
												var parts = document.URL.substring(pos + 1).split('&');
												if (parts.length > 0)
												{
													NTM.hasUrlParameter = true;
													parts.map(function (i)
													{
														var s = i.split('=');
														if (s.length == 2)
														{
															var s0 = s[0].trim();
															var m = s0.match(/^key(\d+)sk(\d+)$/i);
															if (m == null)
															{
																NTM.urlParams[s0] = NTM.Utils.Url.escape(s[1]);
															} else
															{
																if ((m[1] == 5 && m[2] < 2) || m[1] == 2 || m[1] == 1)
																{
																	NTM.setKey(m[1], m[2], NTM.Utils.Url.escape(s[1]));
																}
															}
														}
													});
												}
											}
										},
										escape: function (unsafe) {
											var dp = unsafe.indexOf('#');
											if (dp > -1)
											{
												unsafe = unsafe.substring(0, dp);
											}
											return unsafe
													.replace(/&/g, "&amp;")
													.replace(/</g, "&lt;")
													.replace(/>/g, "&gt;")
													.replace(/"/g, "&quot;")
													.replace(/'/g, "&#039;")
													.trim();
										}
									},
							Cookie:
									{
										get: function (name)
										{
											var nameEQ = name + "=";
											var ca = document.cookie.split(';');
											for (var i = 0; i < ca.length; i++)
											{
												var c = ca[i];
												while (c.charAt(0) == ' ')
												{
													c = c.substring(1, c.length);
												}
												if (c.indexOf(nameEQ) == 0)
												{
													return c.substring(nameEQ.length, c.length);
												}
											}
											return null;
										},
										getDomainForCookie: function (str)
										{
											var m = str.match(/\./g);
											if (m)
											{
												switch (m.length)
												{
													case 1:
														return '.' + str;
													case 2:
														var p = str.indexOf('.');
														return str.substring(p);
													default:
														var L1 = str.lastIndexOf('.');
														var L2 = str.lastIndexOf('.', L1 - 1);
														return str.substring(L2);
												}
											}
											return str;
										},
										getCookies: function ()
										{
											NTM.cookies = {};
											var parts = document.cookie.split(';');
											if (parts.length > 0)
											{
												parts.map(function (i)
												{
													var pos = i.indexOf('=');
													if (pos != -1)
													{
														NTM.cookies[i.substr(0, pos).trim()] = decodeURIComponent(i.substr(pos + 1));
													}
												});
											}
										},
										set: function (name, value, days)
										{
											if (days)
											{
												var date = new Date();
												date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
												var expires = "; expires=" + date.toUTCString();
											} else
											{
												var expires = "";
											}
											document.cookie = name + "=" + value + expires + ";path=/;domain=" + NTM.cookieDomain + ";";
										},
										del: function (name)
										{
											document.cookie = name + '=; expires=Thu, 2 Aug 2001 20:47:11 UTC; path=/';
										}
									},
							DateTime:
									{
										getTimestamp: function ()
										{
											var tmpDate = new Date();
											return Date.UTC(tmpDate.getUTCFullYear(), tmpDate.getUTCMonth(), tmpDate.getUTCDate(), tmpDate.getUTCHours(), tmpDate.getUTCMinutes(), tmpDate.getUTCSeconds());
										}
									}
						},
				getKey: function (keyIndex, subKeyIndex)
				{
					var keyString = 'key' + keyIndex;
					var subKeyString = 'sk' + subKeyIndex;
					if (NTM.keys.hasOwnProperty(keyString))
					{
						if (NTM.keys[keyString].hasOwnProperty(subKeyString))
						{
							return NTM.keys[keyString][subKeyString];
						}
					}
					return '';
				},
				setKey: function (keyIndex, subKeyIndex, value)
				{
					var keyString = 'key' + keyIndex;
					var subKeyString = 'sk' + subKeyIndex;
					var fullKeyString = keyString + subKeyString;
					if (NTM.keys.hasOwnProperty(keyString))
					{
						NTM.keys[keyString]['sk' + subKeyIndex] = value;
						if (subKeyIndex > NTM.last_pointers[keyString])
						{
							NTM.last_pointers[keyString] = parseInt(subKeyIndex);
						}
					}
				},
				getPageID: function (url)
				{
					var req = $.ajax(
							{
								url: NTM.serviceURL,
								type: 'POST',
								dataType: 'text',
								data: 'usf=getUrlId&url=' + encodeURIComponent(url.toLowerCase()),
								async: false,
								cache: false,
								success: function (data)
								{
									if ((data.length < 1 || data.length > 10) || isNaN(data))
									{
										data = '0000';
									}
									return data;
								}
							});
					if (req.statusText == 'OK')
					{
						return req.responseText;
					}
					return '';
				},
				setKey6Parameters: function ()
				{
					$.ajax(
							{
								url: NTM.serviceURL,
								type: 'POST',
								dataType: 'text',
								data: 'dataReferrer=' + encodeURIComponent(document.referrer) + '&usf=retrieveInfo',
								async: false,
								cache: false,
								success: function (data)
								{
									var parts = data.split('&');
									var m;
									if (parts.length > 0)
									{
										parts.map(function (i)
										{
											var s = i.split('=');
											if (s.length == 2)
											{
												m = s[0].match(/key(\d)sk(\d+)/i);
												if (m != null && m.length == 3)
												{
													NTM.setKey(m[1], m[2], decodeURIComponent(s[1]));
												} else
												{
													if (s[0] == 'n_sha')
													{
														NTM.cookies[s[0]] = s[1];
													}
												}
											}
										});
									}
								}
							});
					NTM.setKey(6, 7, NTM.Utils.Url.getReferrer());
					if (FlashDetect.installed)
					{
						NTM.setKey(6, 8, FlashDetect.major.toString() + FlashDetect.minor.toString() + FlashDetect.revision.toString());
					}
					NTM.setKey(6, 9, screen.width.toString() + screen.height.toString());
					NTM.setKey(6, 10, navigator.javaEnabled());
					NTM.setKey(6, 11, NTM.cookies.n_sha);
					NTM.setKey(6, 12, NTM.version);
				},
				setKeyIfNotExists: function (keyIndex, subKeyIndex, value)
				{
					var keyString = 'key' + keyIndex;
					var subKeyString = 'sk' + subKeyIndex;
					var fullKeyString = keyString + subKeyString;
					if (NTM.keys.hasOwnProperty(keyString))
					{
						if (!NTM.keys[keyString].hasOwnProperty(subKeyString))
						{
							NTM.setKey(keyIndex, subKeyIndex, value);
						}
					}
				},
				checkChannel: function ()
				{
					if (NTM.hasUrlParameter || NTM.getKey(6, 7) == 'Google' || NTM.getKey(6, 7) == 'Yahoo' || NTM.getKey(6, 7) == 'Bing')
					{
						if (NTM.getKey(1, 1) == 'sem' || NTM.getKey(1, 1) == 'em' || NTM.getKey(1, 1) == 'upl')
						{
							NTM.campaignMon.funcSEMEMUPL([NTM.getKey(1, 1), NTM.urlParams["afl"]]);
							return;
						}
						if ((NTM.getKey(1, 1) != 'sem' || NTM.getKey(1, 1) != '' || NTM.getKey(1, 1) != 'dt') && (NTM.getKey(6, 7) == 'Google' || NTM.getKey(6, 7) == 'Yahoo' || NTM.getKey(6, 7) == 'Bing'))
						{
							NTM.campaignMon.funcORS(NTM.getKey(6, 7));
							return;
						}
						if (NTM.urlParams['rs'] != undefined)
						{
							NTM.campaignMon.funcApp(['rs', NTM.urlParams['pid'], NTM.urlParams['rs']]);
							return;
						}
						if (NTM.urlParams['d'] != undefined)
						{
							NTM.campaignMon.funcApp(['d', NTM.urlParams['stage'], NTM.urlParams['d']]);
							return;
						}
						if (typeof (NTM.urlParams['subaffiliateid']) !== 'undefined' && NTM.urlParams['subaffiliateid'] != '')
						{
							NTM.campaignMon.funcSTeam(NTM.urlParams['subaffiliateid']);
							return;
						}
						if (NTM.getKey(1, 1) == '')
						{
							NTM.campaignMon.funcDT();
						}
					} else
					{
						NTM.campaignMon.funcDT();
					}
				},
				checkKeywords: function ()
				{
					var m = document.referrer.match(/http(s|):\/\/www\.google\.com.*q=([^&]*).*/i);
					if (m != null && m.length == 3)
					{
						if (NTM.getKey(1, 3) == '')
						{
							NTM.setKey(1, 3, decodeURIComponent(m[2]));
						}
						NTM.setKey(6, 1, NTM.getKey(1, 3));
						return;
					}
					m = document.referrer.match(/http:\/\/.*yahoo\.com\/search;.*\?p=([^&]*).*/i);
					if (m != null && m.length == 2)
					{
						if (NTM.getKey(1, 3) == '')
						{
							NTM.setKey(1, 3, decodeURIComponent(m[1]));
						}
						NTM.setKey(6, 1, NTM.getKey(1, 3));
						return;
					}
					m = document.referrer.match(/http:\/\/www\.bing\.com.*q=([^&]*).*/i);
					if (m != null && m.length == 2)
					{
						if (NTM.getKey(1, 3) == '')
						{
							NTM.setKey(1, 3, decodeURIComponent(m[1]));
						}
						NTM.setKey(6, 1, NTM.getKey(1, 3));
						return;
					}
				},
				getPixelUrl: function ()
				{
					var str = [];
					for (var param in NTM.urlParams)
					{
						str.push(param + '=' + NTM.urlParams[param]);
					}
					if (NTM.initialVisit)
					{
						for (var key in NTM.keys)
						{
							if (key == 'key1' || key == 'key2' || key == 'key6' || key == 'key4')
							{
								for (var sk in NTM.keys[key])
								{
									if (NTM.keys[key][sk] != '')
									{
										str.push(key + sk + '=' + NTM.keys[key][sk]);
									}
								}
							}
						}
					}
					for (var key in NTM.keys)
					{
						if (key == 'key5' || key == 'key7')
						{
							for (var sk in NTM.keys[key])
							{
								if (NTM.keys[key][sk] != '')
								{
									str.push(key + sk + '=' + NTM.keys[key][sk]);
								}
							}
						}
					}
					return str.join('&');
				},
				campaignMon:
						{
							funcSEMEMUPL: function (args)
							{
								NTM.setKeyIfNotExists(1, 1, args[0]);
								NTM.setKeyIfNotExists(1, 2, NTM.getKey(6, 7));
								if (args[1])
								{
									NTM.setKeyIfNotExists(1, 5, args[1]);
								}
							},
							funcORS: function (se)
							{
								NTM.setKeyIfNotExists(1, 1, 'ors');
								NTM.setKeyIfNotExists(1, 2, NTM.getKey(6, 7));
								if (NTM.getKey(6, 1) != '')
								{
									NTM.setKeyIfNotExists(1, 3, NTM.getKey(6, 1));
								}
							},
							funcApp: function (args)
							{
								NTM.setKeyIfNotExists(1, 1, 'app');
								if (args[0] == 'rs')
								{
									NTM.setKeyIfNotExists(1, 2, 'CIS');
									NTM.setKeyIfNotExists(1, 3, args[1]);
									NTM.setKeyIfNotExists(1, 4, args[2]);
								} else if (args[0] == 'd')
								{
									NTM.setKeyIfNotExists(1, 2, 'GBTBA');
									NTM.setKeyIfNotExists(1, 3, args[1]);
									NTM.setKeyIfNotExists(1, 4, args[2]);
								}
							},
							funcSTeam: function (args)
							{
								NTM.setKeyIfNotExists(1, 1, 'st');
								NTM.setKeyIfNotExists(1, 5, args);
							},
							funcDT: function ()
							{
								NTM.setKeyIfNotExists(1, 1, 'dt');
								NTM.setKeyIfNotExists(1, 2, NTM.getKey(6, 7));
								NTM.setKeyIfNotExists(1, 3, NTM.getKey(6, 1));
							}
						}
			}
	NTM.start();
	$(document.body).append('<img src="' + NTM.pixelURL + '?' + NTM.getPixelUrl() + '" style="display:none" />');
});