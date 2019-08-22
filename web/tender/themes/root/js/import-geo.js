$(document).ready(function () {

	$import = {
		url: ''
	};

	/*
	 * table
	 */
	$handle_output_table_id = 'handle_output_table';
	$handle_output_tr_id = '';
	$handle_output_table_container = '';
	$handle_output_table_column_limit = 6;
	$handle_output_table_row_limit = 6;
	function handle_output($object) {
		var $content = '';
		for (var $key in $object.data) {
			if ($object.data.hasOwnProperty($key)) {
				$content = $content + '<span class="o_h"><b>' + $key + '</b>: ' + $object.data[$key] + '</span><br/>';
			}
		}

		if (document.getElementById($handle_output_table_id) === null) {
			$('#import_output').append('<div id="' + $handle_output_table_id + '" class="d_t bc_c w_100"></div>');
			$handle_output_table_container = $('#' + $handle_output_table_id);
			$handle_output_tr_id = 'handle_output_tr_' + Math.random().toString(36).substring(7);
			$handle_output_table_container.append('<div id="' + $handle_output_tr_id + '" class="d_tr"></div>');
			$handle_output_tr_container = $('#' + $handle_output_tr_id);
			$handle_output_table_column_count = 1;
			$handle_output_table_row_count = 1;
			console.log('table');
		}

		$handle_output_tr_container.append('<div class="d_tc bs_s">' + $content + '</div>');
		if (($handle_output_table_column_count / $handle_output_table_column_limit) % 1 === 0) {
			$handle_output_table_container = $('#' + $handle_output_table_id);
			$handle_output_tr_id = 'handle_output_tr_' + Math.random().toString(36).substring(7);
			$handle_output_table_container.append('<div id="' + $handle_output_tr_id + '" class="d_tr"></div>');
			$handle_output_tr_container = $('#' + $handle_output_tr_id);
			$handle_output_table_row_count++;
		}

		if (($handle_output_table_row_count / $handle_output_table_row_limit) % 1 === 0) {
			$('#import_output').html('');
		}

		$handle_output_table_column_count++;
	}

	/*
	 * progress bar
	 */
	function handle_proress_bar($object) {
		$('#progress_bar_scale').css({width: $object.progress.percents + '%'});
		$('#progress_bar_text').html($handle_output_table_row_count + '-' + $handle_output_table_column_count + ' : ' + $object.progress.row + ' / ' + $object.progress.rows + ' (' + $object.progress.percents + '%)');
	}

	function url_import($object) {
		var $ajax;
		var $json;
		// var $url = '/import_geo/continent';
		$fa.ajax.send(
			// $url,
			$import.url,
			'post',
			$object,
			true,
			function ($xhr) {
				$ajax = $fa.parse.ajax($xhr);
				$json = $fa.parse.json($ajax);
				if ($json !== false) {
					handle_output($json);
					handle_proress_bar($json);
					// console.log($json.data.next);
					$import.url = $json.progress.next;
					url_import($json);
				} else {
					console.log('import end');
				}
			}
		);
	}

	$('#import_button_continents').click(function () {

		$import.url = '/import_geo/continent/1';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});

	$('#import_button_countries').click(function () {

		$import.url = '/import_geo/country/1';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});
	$('#import_button_regions').click(function () {

		$import.url = '/import_geo/region/1';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});
	$('#import_button_devisions').click(function () {

		$import.url = '/import_geo/devision/1';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});
	$('#import_button_timezones').click(function () {

		$import.url = '/import_geo/timezone';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});
	$('#import_button_cities').click(function () {

		$import.url = '/import_geo/city/1';

		console.log('import start');
		$handle_output_table_column_count = 1;
		$('#import_output').html('');
		url_import();
		return false;
	});


});
