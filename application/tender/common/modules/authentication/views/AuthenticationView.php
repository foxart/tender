<?php

namespace tender\common\modules\authentication\views;

use fa\classes\View;
use fa\core\faf;

class AuthenticationView extends View {

	public static $instance;

	public function handleValidations($errors) {
		$result = array();
		foreach ($errors as $key => $value) {
			if ($value === TRUE) {
				$result[$key . '_validation'] = '';
				$result[$key . '_validation_class'] = 'has-success';
				$result[$key . '_feedback_class'] = 'glyphicon-ok';
			} elseif ($value === NULL) {
				$result[$key . '_validation'] = '';
				$result[$key . '_validation_class'] = '';
				$result[$key . '_feedback_class'] = '';
			} else {
				$result[$key . '_validation'] = $errors[$key];
				$result[$key . '_validation_class'] = 'has-error';
				$result[$key . '_feedback_class'] = 'glyphicon-remove';
			}
		}

		return $result;
	}

	/*
	 * SIGN IN
	 */
	public function renderSignInForm($data, $errors) {
		$validations = $this->handleValidations($errors);
		$this->template()->load('application/tender/common/modules/authentication/templates/authenticationSignInForm.twig')->set([
			'authentication_email' => $data['authentication_email'],
			'authentication_password' => $data['authentication_password'],
		])->set($validations)->set([
			'sign_in_url' => faf::router()->urlTo('/authentication/sign-in'),
			'sign_up_url' => faf::router()->urlTo('/authentication/sign-up'),
			'reset_url' => faf::router()->urlTo('/authentication/reset'),
		]);

		return $this->template()->render();
	}

	/*
	 * SIGN UP
	 */
	public function renderSignUpForm($data, $errors) {
		$validations = $this->handleValidations($errors);
//		$options = [];
//		$account_type_options = $this->Model()->getAccountTypeList();
//		foreach ($account_type_options as $item) {
//			if ($data['account_type_id'] == $item['account_type_id']) {
//				$options[] = faf::html()->option([
//					'value' => $item['account_type_id'],
//					'selected' => 'selected',
//				], $item['account_type_name']);
//			} else {
//				$options[] = faf::html()->option([
//					'value' => $item['account_type_id'],
//				], $item['account_type_name']);
//			}
//		}
//		$account_type_options = implode('', $options);
		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationSignUpForm.twig')->set([
//			'account_type_options' => $account_type_options,
			'account_name' => $data['account_name'],
			'authentication_email' => $data['authentication_email'],
			'authentication_password' => $data['authentication_password'],
			'authentication_password_confirm' => $data['authentication_password_confirm'],
		])->set($validations)->set([
			'sign_in_url' => faf::router()->urlTo('/authentication/sign-in'),
			'reset_url' => faf::router()->urlTo('/authentication/reset'),
			'sign_up_url' => faf::router()->urlTo('/authentication/sign-up'),
		])->render();
	}

	public function renderSignUpEmail($data, $registration_code, $password) {
		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationSignUpEmail.twig')->set([
			'account_name' => $data['account_name'],
			'authentication_email' => $data['authentication_email'],
			'authentication_password' => $password,
			'application_name' => faf::$configuration['application']['name'],
			'application_url' => faf::request()->createUrl([
				'path' => faf::router()->urlTo('/'),
			]),
			'support_email' => 'support@' . faf::request()->host(),
			'action_url' => faf::request()->createUrl([
				'path' => faf::router()->urlTo('/authentication/sign-up/confirm/registration_code', [
					'registration_code' => $registration_code,
				]),
			]),
		])->render();
	}

	public function renderSignUpFeedback($message) {
		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationSignUpFeedback.twig')->set([
			'message' => $message,
		])->render();
	}

	/*
	 * PASSWORD
	 */
	public function renderResetForm($data, $errors) {
		$validations = $this->handleValidations($errors);

		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationResetForm.twig')->set($data)->set($validations)->set([
			'sign_in_url' => faf::request()->createUrl(['path' => faf::router()->urlTo('/authentication/sign-in')]),
			'sign_up_url' => faf::router()->urlTo('/authentication/sign-up'),
			'reset_url' => faf::router()->urlTo('/authentication/reset'),
		])->render();
	}

	public function renderResetRequestEmail($account_name, $password_code) {
		$agent = faf::server()->getAgent();

		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationResetRequestEmail.twig')->set([
			'account_name' => $account_name,
			'application_name' => faf::$configuration['application']['name'],
			'application_url' => faf::request()->createUrl([
				'path' => faf::router()->urlTo('/'),
			]),
			'platform_name' => $agent['platform'],
			'browser_name' => $agent['browser'],
			'support_email' => 'support@' . faf::request()->host(),
			'action_url' => faf::request()->createUrl([
				'path' => faf::router()->urlTo('/authentication/reset/confirm/password_code', [
					'password_code' => $password_code,
				]),
			]),
		])->render();
	}

	public function renderResetConfirmEmail($account_name, $authentication_email, $password) {
		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationResetConfirmEmail.twig')->set([
			'account_name' => $account_name,
			'application_name' => faf::$configuration['application']['name'],
			'authentication_email' => $authentication_email,
			'authentication_password' => $password,
			'action_url' => faf::request()->createUrl([
				'path' => faf::router()->urlTo('/authentication/sign-in'),
			]),
		])->render();
	}

	public function renderResetFeedback($message) {
		return $this->template()->load('application/tender/common/modules/authentication/templates/authenticationResetFeedback.twig')->set([
			'message' => $message,
		])->render();
	}
}
