$(document).ready(function () {

	// $fa.debug.create();
	// $fa.debug.log(document);
	// console.log(document);
	/**
	 * open link in a new window
	 */
	$(document).on('click', '.fa-js-blank', function () {
		window.open($(this).attr('href'), '_blank');
		return false;
	});
	$(document).on('click', '.fa-js-ajax', function () {
		var $metadata = $fa.dom.metadata(this);
		if ($metadata === undefined) {
			console.error('metadata not found:', this);
			return false;
		}
		if ($($metadata.container).length === 0) {
			console.error('metadata container not found:', $metadata.container);
			return false;
		}
		if ($metadata.url === undefined) {
			console.error('metadata url not set');
			return false;
		}
		if ($metadata.method === undefined) {
			$metadata.method = 'get';
		}
		if ($metadata.type === undefined) {
			$metadata.type = 'html';
		}
		/**
		 * ajax call
		 */
		$.ajax({
			url: $metadata.url,
			type: $metadata.method,
			dataType: $metadata.type,
			success: function (data) {
				$($metadata.container).html(data);
				if ($metadata.callback !== undefined) {
					$fa.execute.function($metadata.callback);
				}
			},
			error: function (data) {
				console.error('ajax load error:', $metadata.url);
				$($metadata.container).html(data.responseText);
				// $fa.debug.create();
				// $fa.debug.log(data.responseText);
			}
		});
		return false;
	});
});
