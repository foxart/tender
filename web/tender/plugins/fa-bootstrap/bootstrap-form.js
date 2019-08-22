$(document).on('submit', '.bs-form', function () {
	var $metadata = $fa.dom.metadata(this);
	if ($metadata === undefined) {
		console.error('metadata not found:', this);
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
	$.data(document.body, 'bs-form', $metadata);
	$.ajax({
		url: $metadata.submit,
		type: 'get',
		data: $('form[name="' + $(this).find('form').attr('name') + '"]').serialize(),
		context: this,
		// dataType: 'json',
		success: function (data) {
			$fa.validator.bootstrap.resetErrors($(this).find('form').attr('name'));
			// if (request.getResponseHeader('Content-Type') === 'application/json') {
			try {
				$fa.validator.bootstrap.highlightErrors($(this).find('form').attr('name'), $.parseJSON(data));
			} catch (Exception) {
				$($metadata.container).html(data);
			}
		},
		error: function (data) {
			console.error('error');
			$($metadata.container).html(data.responseText);
		}
	});
	return false;
});
