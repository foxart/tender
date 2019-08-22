/**
 * foxart framework
 *
 * VALIDATOR
 *
 * http://foxart.org
 */
if ($fa.validator === undefined) {
	$fa.fn = $fa.validator = {
		bootstrap: fn = {
			resetErrors: function ($form) {
				var $validation = document.forms[$form].getElementsByClassName('bs-validate');
				for (var $i = 0; $i < $validation.length; $i++) {
					$validation[$i].parentNode.className = $validation[$i].parentNode.className.replace(' has-error', '');
					if ($validation[$i].parentNode.getElementsByClassName('help-block')[0] !== undefined) {
						$validation[$i].parentNode.removeChild($validation[$i].parentNode.getElementsByClassName('help-block')[0]);
					}
				}
				var $validation_feedback = document.forms[$form].getElementsByClassName('bs-validate-feedback');
				for (var $j = 0; $j < $validation_feedback.length; $j++) {
					$validation_feedback[$j].parentNode.className = $validation_feedback[$j].parentNode.className.replace(' has-error', '');
					$validation_feedback[$j].parentNode.className = $validation_feedback[$j].parentNode.className.replace(' has-success', '');
					$validation_feedback[$j].parentNode.className = $validation_feedback[$j].parentNode.className.replace(' has-feedback', '');
					if ($validation_feedback[$j].parentNode.getElementsByClassName('form-control-feedback')[0] !== undefined) {
						$validation_feedback[$j].parentNode.removeChild($validation_feedback[$j].parentNode.getElementsByClassName('form-control-feedback')[0]);
					}
					if ($validation_feedback[$j].parentNode.getElementsByClassName('help-block')[0] !== undefined) {
						$validation_feedback[$j].parentNode.removeChild($validation_feedback[$j].parentNode.getElementsByClassName('help-block')[0]);
					}
				}
			},
			highlightErrors: function ($form, $errors) {
				var $validation = document.forms[$form].getElementsByClassName('bs-validate');
				for (var $i = 0; $i < $validation.length; $i++) {
					if ($errors[$validation[$i].id] !== true) {
						$validation[$i].parentNode.className += ' has-error';
						$validation[$i].insertAdjacentHTML('afterend', '<span class="help-block with-errors">' + $errors[$validation[$i].id] + '</span>');
					}
				}
				var $validation_feedback = document.forms[$form].getElementsByClassName('bs-validate-feedback');
				for (var $j = 0; $j < $validation_feedback.length; $j++) {
					if ($errors[$validation_feedback[$j].id] === true) {
						$validation_feedback[$j].parentNode.className += ' has-success has-feedback';
						$validation_feedback[$j].insertAdjacentHTML('afterend', '<span class="form-control-feedback glyphicon glyphicon-ok"></span>');
					} else {
						$validation_feedback[$j].parentNode.className += ' has-error has-feedback';
						$validation_feedback[$j].insertAdjacentHTML('afterend', '<span class="help-block with-errors">' + $errors[$validation_feedback[$j].id] + '</span>');
						$validation_feedback[$j].insertAdjacentHTML('afterend', '<span class="form-control-feedback glyphicon glyphicon-remove"></span>');
					}
				}
			}
		}
	}
}
