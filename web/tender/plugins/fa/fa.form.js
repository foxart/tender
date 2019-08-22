/**
 * foxart framework
 * FORM
 * fa.form.js
 *
 * http://foxart.org
 */
if ($fa.form === undefined) {
	$fa.fn = $fa.form = {
		reset: function ($form) {
			for (var $key = 0; $key < document.forms[$form].elements.length; $key++) {
				var $element = document.forms[$form].elements[$key];
				if ($element.type === 'text') {
					$element.value = '';
				}
				if ($element.options !== undefined) {
					for (var $options_key = 0, $options_length = $element.options.length; $options_key < $options_length; $options_key++) {
						$element.options[$options_key].selected = $element.options[$options_key].defaultSelected;
						// console.log($key);
					}
				}
				// console.log($key, $element.type, $element.value);
			}
		},
		populate: function ($form, $data) {
			if (document.forms[$form] !== undefined) {
				// for (var $key in $data) {
				for (var $key = 0; $key < document.forms[$form].elements.length; $key++) {
					var $element = document.forms[$form].elements[$key];
					if ($element.name !== '') {
						// console.log($element.type);
						// console.log($element.tagName);
						if ($data[$element.name] !== undefined) {
							switch ($element.type) {
								case 'checkbox':
									// $element.checked = $element.value === $data[$element.name];
									if ($element.value === $data[$element.name]) {
										$element.checked = true;
									} else {
										$element.checked = false;
									}
									break;
								case 'radio':
									if ($element.value === $data[$element.name]) {
										$element.checked = true;
									} else {
										$element.checked = false;
									}
									break;
								case 'select-one':
									if ($data[$element.name] == null) {
										$element.value = 0;
									} else {
										$element.value = $data[$element.name];
									}
									break;
								default:
									$element.value = $data[$element.name];
							}
						} else {
							console.warn($form, $element.name + ': no data');
						}
					}
				}
			} else {
				console.error($form + ': not found');
			}
		}
	}
}
