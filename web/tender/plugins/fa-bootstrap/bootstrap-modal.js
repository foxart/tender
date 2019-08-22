function bootstrap_modal_populate($form, $data) {
	if (document.forms[$form] === undefined) {
		throw {
			message: 'form not found',
			form: $form
		};
	}
	for (var $key in $data) {
		var $element = document.forms[$form].elements[$key];
		if ($element !== undefined) {
			switch ($element.type) {
				case 'checkbox':
					// $element.checked = $element.value === $data[$element.name];
					if ($element.value === $data[$key]) {
						$element.checked = true;
					} else {
						$element.checked = false;
					}
					break;
				case 'radio':
					if ($element.value === $data[$key]) {
						$element.checked = true;
					} else {
						$element.checked = false;
					}
					break;
				case 'select-one':
					if ($data[$key] == null) {
						$element.value = 0;
					} else {
						$element.value = $data[$key];
					}
					break;
				default:
					$element.value = $data[$key];
			}
		} else {
			// console.error($form, $key + ': no field');
			throw {
				message: 'field not found',
				form: $form,
				field: $key
			};
		}
	}
}
function bootstrap_modal_populate_reset($form) {
	for (var $key = 0; $key < document.forms[$form].elements.length; $key++) {
		var $element = document.forms[$form].elements[$key];
		if ($element.type === 'text') {
			$element.value = '';
		}
		if ($element.type === 'textarea') {
			$element.value = '';
		}
		if ($element.options !== undefined) {
			for (var $options_key = 0, $options_length = $element.options.length; $options_key < $options_length; $options_key++) {
				$element.options[$options_key].selected = $element.options[$options_key].defaultSelected;
			}
		}
	}
}
function bootstrap_modal_show($form) {
	var $data = $.data(document.body, 'bs-modal');
	if ($data.disable !== undefined) {
		if ($.isEmptyObject($data.disable) === true) {
			var $elements = $('form[name="' + $form + '"]').find('.form-control');
			for (var $key = 0; $key < $elements.length; $key++) {
				$('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').attr('disabled', 'disabled');
			}
		} else {
			for (var $key in  $data.disable) {
				var $element = $('form[name="' + $form + '"] [name="' + $data.disable[$key] + '"]');
				if ($element.length === 1) {
					$element.attr('disabled', 'disabled');
				} else {
					console.error('element not found:', $data.disable[$key]);
					return false;
				}
			}
		}
	}
	$($data.modal).modal({
		show: true,
		keyboard: true,
		backdrop: 'static'
	});
	if ($data.callback !== undefined) {
		$fa.execute.function($data.callback);
	}
}
function bootstrap_modal($metadata) {
	if ($metadata === undefined) {
		console.error('metadata not found');
		return false;
	}
	if ($($metadata.modal).length === 0) {
		console.error('metadata modal not found:', $metadata.modal);
		return false;
	}
	if ($($metadata.container).length === 0) {
		console.error('metadata container not found:', $metadata.container);
		return false;
	}
	if ($metadata.submit === undefined) {
		console.error('metadata sumbit not set');
		return false;
	}
	if ($metadata.reload === undefined) {
		console.error('metadata reload not set');
		return false;
	}
	if ($metadata.title === undefined) {
		console.error('metadata title not found:', $metadata.modal);
		return false;
	} else {
		$($metadata.modal).find('.modal-title').html($metadata.title);
	}
	// if ($($metadata.modal).attr('tabindex') === undefined) {
	// $($metadata.modal).attr('tabindex', 0);
	// }
	var $form = $($metadata.modal + ' form').attr('name');
	if ($form === undefined) {
		console.error('form not found for modal:', $metadata.modal);
		return false;
	}
	var $title = $('form[name="' + $form + '"] .modal-title');
	if ($title.length === 0) {
		console.error('form title not found for modal:', $metadata.modal);
		return false;
	}
	$title.html($metadata.title);
	var $submit = $('form[name="' + $form + '"] button[type="submit"]');
	if ($submit.length === 0) {
		console.error('form submit not found for modal:', $metadata.modal);
		return false;
	}
	$.data(document.body, 'bs-modal', $metadata);
	//reset data
	bootstrap_modal_populate_reset($form);
	//reset validation
	bootstrap_feedback_reset($form);
	if ($metadata.populate !== undefined) {
		$.ajax({
			url: $metadata.populate,
			type: 'get',
			dataType: 'json',
			success: function (data) {
				bootstrap_modal_populate($form, data);
				bootstrap_modal_show($form);
			},
			error: function (data) {
				console.error('populate data load error:', $metadata.populate);
				$($metadata.container).html(data.responseText);
			}
		});
	} else {
		$($metadata.modal).modal({
			show: true,
			keyboard: true,
			backdrop: 'static'
		});
		if ($metadata.callback !== undefined) {
			$fa.execute.function($metadata.callback);
		}
	}
	return false;
}
$(document).on('hidden.bs.modal', function () {
	var $data = $.data(document.body, 'bs-modal');
	if ($data === undefined) {
		console.error('data not found:', this);
		return false;
	}
	// $submit.attr('disabled', false);
	var $form = $($data.modal + ' form').attr('name');
	var $submit = $('form[name="' + $form + '"] button[type="submit"]');
	$submit.attr('disabled', false);
	if ($data.disable !== undefined) {
		if ($.isEmptyObject($data.disable) === true) {
			var $elements = $('form[name="' + $form + '"]').find('.form-control');
			for (var $key = 0; $key < $elements.length; $key++) {
				$('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').removeAttr('disabled');
			}
		} else {
			for (var $key in  $data.disable) {
				var $element = $('form[name="' + $form + '"] [name="' + $data.disable[$key] + '"]');
				if ($element.length === 1) {
					$element.removeAttr('disabled');
				} else {
					console.error('element not found:', $data.disable[$key]);
					return false;
				}
			}
		}
	}
	if ($data.html !== undefined) {
		$($data.container).html($data.html);
		delete $data.html;
	}
});
$(document).on('click', '.bs-modal .cancel', function () {
	var $data = $.data(document.body, 'bs-modal');
	if ($data === undefined) {
		console.error('data not found:', this);
		return false;
	}
	$($data.modal).modal('hide');
	// var $form = $($data.modal + ' form').attr('name');
	// var $submit = $('form[name="' + $form + '"] button[type="submit"]');
	// $submit.attr('disabled', false);
	return false;
});
$(document).on('submit', '.bs-modal', function () {
	var $data = $.data(document.body, 'bs-modal');
	if ($data === undefined) {
		console.error('data not found:', this);
		return false;
	}
	var $form = $($data.modal + ' form').attr('name');
	var $submit = $('form[name="' + $form + '"] button[type="submit"]');
	$submit.attr('disabled', true);
	// console.log($('form[name="' + $form + '"] input[type="file"]').length);
	if ($('form[name="' + $form + '"] input[type="file"]').length == 0) {
		$.ajax({
			url: $data.submit,
			type: 'post',
			data: $($data.modal + ' form').serializeArray(),
			dataType: 'json',
			success: function (data) {
				if (Object.keys(data).length !== 0) {
					bootstrap_feedback_reset($form);
					bootstrap_feedback_highlight($form, data);
				} else {
					$.ajax({
						url: $data.reload,
						type: 'post',
						dataType: 'html',
						success: function (data) {
							$data.html = data;
							$($data.modal).modal('hide');
						},
						error: function (data) {
							console.error('container reload error:', $data.reload);
							$data.html = data.responseText;
							$($data.modal).modal('hide');
						}
					})
				}
				$submit.attr('disabled', false);
			},
			error: function (data) {
				console.error('form submit error:', $data.submit);
				$data.html = data.responseText;
				$($data.modal).modal('hide');
			}
		});
	} else {
		$.ajax({
			url: $data.submit,
			type: 'post',
			data: new FormData($($data.modal + ' form')[0]),
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function (data) {
				if (Object.keys(data).length !== 0) {
					bootstrap_feedback_reset($form);
					bootstrap_feedback_highlight($form, data);
				} else {
					$.ajax({
						url: $data.reload,
						type: 'post',
						dataType: 'html',
						success: function (data) {
							$data.html = data;
							$($data.modal).modal('hide');
						},
						error: function (data) {
							console.error('container reload error:', $data.reload);
							$data.html = data.responseText;
							$($data.modal).modal('hide');
						}
					})
				}
				$submit.attr('disabled', false);
			},
			error: function (data) {
				console.error('form submit error:', $data.submit);
				$data.html = data.responseText;
				$($data.modal).modal('hide');
			}
		});
	}
	return false;
});
$(document).on('click', '.bs-modal-link', function () {
	var $metadata = $fa.dom.metadata(this);
	bootstrap_modal($metadata)
});
