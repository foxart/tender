function bootstrap_feedback_highlight($form, $errors) {
	var $elements = $('form[name="' + $form + '"]').find('.form-control');
	var $has_feedback;
	var $has_feedback_icon;
	var $help_block;
	for (var $key = 0; $key < $elements.length; $key++) {
		// $has_feedback = $('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').parents().closest('.has-feedback');
		// if ($has_feedback.length === 0) {
		// 	console.error('feedback not found for:', $errors[$elements[$key]]);
		// }

		$has_feedback = $('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').parents().closest('.form-group').children().closest('.has-feedback');
		$has_feedback_icon = $has_feedback.find('.form-control-feedback');
		$help_block = $has_feedback.find('.help-block');
		if ($errors[$elements[$key].name] !== undefined) {
			$has_feedback.addClass('has-error');
			$has_feedback_icon.addClass('glyphicon glyphicon-remove');
			$help_block.html($errors[$elements[$key].name]);
		} else {
			$has_feedback.addClass('has-success');
			$has_feedback_icon.addClass('glyphicon glyphicon-ok');
			$help_block.html('');
		}
	}
	// console.log($errors);
	// console.log($errors.length);
	// var $error_elements_fake = document.forms[$form].getElementsByClassName('bs-validate-fake');
	// for (var $i = 0; $i < $error_elements_fake.length; $i++) {
	// 	if ($errors[$error_elements_fake[$i].id] !== undefined) {
	// 		$error_elements_fake[$i].parentNode.className += ' has-error';
	// 		$error_elements_fake[$i].insertAdjacentHTML('afterend', '<span class="help-block with-errors">' + $errors[$error_elements_fake[$i].id] + '</span>');
	// 	}
	// }
	// var $error_elements = document.forms[$form].getElementsByClassName('bs-validate');
	// for (var $j = 0; $j < $error_elements.length; $j++) {
	// 	if ($errors[$error_elements[$j].name] !== undefined) {
	// 		$error_elements[$j].parentNode.className += ' has-error';
	// 		$error_elements[$j].insertAdjacentHTML('afterend', '<span class="help-block with-errors">' + $errors[$error_elements[$j].name] + '</span>');
	// 	}
	// }
	// var $error_elements_feedback = document.forms[$form].getElementsByClassName('bs-validate-feedback');
	// for (var k = 0; k < $error_elements_feedback.length; k++) {
	// 	if ($errors[$error_elements_feedback[k].name] === undefined) {
	// 		$error_elements_feedback[k].parentNode.className += ' has-success has-feedback';
	// 		if ($error_elements_feedback[k].tagName === 'INPUT') {
	// 			$error_elements_feedback[k].insertAdjacentHTML('afterend', '<span class="form-control-feedback glyphicon glyphicon-ok"></span>');
	// 		}
	// 	} else {
	// 		$error_elements_feedback[k].parentNode.className += ' has-error has-feedback';
	// 		$error_elements_feedback[k].insertAdjacentHTML('afterend', '<span class="help-block with-errors">' + $errors[$error_elements_feedback[k].name] + '</span>');
	// 		if ($error_elements_feedback[k].tagName === 'INPUT') {
	// 			$error_elements_feedback[k].insertAdjacentHTML('afterend', '<span class="form-control-feedback glyphicon glyphicon-remove"></span>');
	// 		}
	// 	}
	// }
}
function bootstrap_feedback_reset($form) {
	var $has_feedback;
	var $has_feedback_icon;
	var $help_block;
	var $elements = $('form[name="' + $form + '"]').find('.form-control');
	for (var $key = 0; $key < $elements.length; $key++) {
		// $has_feedback = $('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').parents().closest('.has-feedback');
		$has_feedback = $('form[name="' + $form + '"] [name="' + $elements[$key].name + '"]').parents().closest('.form-group').children().closest('.has-feedback');
		$has_feedback_icon = $has_feedback.find('.form-control-feedback');
		$help_block = $has_feedback.find('.help-block');
		$has_feedback.removeClass('has-success').removeClass('has-error');
		$has_feedback_icon.removeClass('glyphicon').removeClass('glyphicon-ok').removeClass('glyphicon-remove');
		$help_block.html('');
	}
	// var $elements = document.forms[$form].getElementsByTagName('*');
	// var $fake_elements = document.forms[$form].getElementsByClassName('bs-validate-fake');
	// for (var $i = 0; $i < $fake_elements.length; $i++) {
	// 	$fake_elements[$i].parentNode.className = $fake_elements[$i].parentNode.className.replace(' has-error', '');
	// 	if ($fake_elements[$i].parentNode.getElementsByClassName('help-block')[0] !== undefined) {
	// 		$fake_elements[$i].parentNode.removeChild($fake_elements[$i].parentNode.getElementsByClassName('help-block')[0]);
	// 	}
	// }
	// var $error_elements = document.forms[$form].getElementsByClassName('bs-validate');
	// for (var $j = 0; $j < $error_elements.length; $j++) {
	// 	$error_elements[$j].parentNode.className = $error_elements[$j].parentNode.className.replace(' has-error', '');
	// 	if ($error_elements[$j].parentNode.getElementsByClassName('help-block')[0] !== undefined) {
	// 		$error_elements[$j].parentNode.removeChild($error_elements[$j].parentNode.getElementsByClassName('help-block')[0]);
	// 	}
	// }
	// var $validation_elements = document.forms[$form].getElementsByClassName('bs-validate-feedback');
	// for (var $k = 0; $k < $validation_elements.length; $k++) {
	// 	$validation_elements[$k].parentNode.className = $validation_elements[$k].parentNode.className.replace(' has-error', '');
	// 	$validation_elements[$k].parentNode.className = $validation_elements[$k].parentNode.className.replace(' has-success', '');
	// 	$validation_elements[$k].parentNode.className = $validation_elements[$k].parentNode.className.replace(' has-feedback', '');
	// 	if ($validation_elements[$k].parentNode.getElementsByClassName('form-control-feedback')[0] !== undefined) {
	// 		$validation_elements[$k].parentNode.removeChild($validation_elements[$k].parentNode.getElementsByClassName('form-control-feedback')[0]);
	// 	}
	// 	if ($validation_elements[$k].parentNode.getElementsByClassName('help-block')[0] !== undefined) {
	// 		$validation_elements[$k].parentNode.removeChild($validation_elements[$k].parentNode.getElementsByClassName('help-block')[0]);
	// 	}
	// }
}
