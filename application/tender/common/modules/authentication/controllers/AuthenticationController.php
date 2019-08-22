<?php

namespace tender\common\modules\authentication\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\authentication\models\AuthenticationModel;
use tender\common\modules\authentication\views\AuthenticationView;

class AuthenticationController extends Controller {

	public static $authorization_key = 'authorization';

	private function Model() {
		return AuthenticationModel::instance();
	}

	private function View() {
		return AuthenticationView::instance();
	}

	public function deleteRequest($account_id) {
		return $this->Model()->delete($account_id);
	}

	public function signInRoot() {
		$data = [
			'account_id' => 0,
			'account_type' => 'root',
			'account_name' => 'Super user',
			'authentication_id' => 0,
			'authentication_email' => 'root@' . faf::request()->host(),
			'authorization_id' => 0,
			'authorization_name' => 'root',
		];
		$this->signInRequest($data);
	}

	/*
	 * SIGN IN
	 */
	public function actionSignIn() {
		$fields = [
			'authentication_fake' => TRUE,
			'authentication_email' => TRUE,
			'authentication_password' => TRUE,
		];
		if (faf::request()->method() === 'post') {
			$post = faf::request()->post();
			if ($post['authentication_email'] === 'root' and md5($post['authentication_password']) === '3db87ad62dcbbc63bd2e316f4e112dfc') {
				$this->signInRoot();
				faf::header()->setLocation('/');
			}
			$this->Model()->load($post)->addValidator('authentication_fake', function () {
//				return $this->Model()->signUpCheck();
//			})->addValidator('authentication_fake', function () {
				return $this->Model()->signInCheck();
			})->addValidator('authentication_fake', function () {
				return $this->Model()->activeCheck();
			})->validate();
			$errors = array_merge($fields, $this->Model()->getErrors());
			if ($this->Model()->valid === TRUE) {
				$model = $this->Model()->signInGet();
//				if ($model['authentication_registration_code'] !== NULL) {
//					$this->Model()->signUpConfirm($model['authentication_registration_code']);
//				}
				$this->signInRequest($model);
				faf::header()->setLocation('/');
			}
		} else {
			$post = array_fill_keys(array_keys($fields), NULL);
			$errors = array_fill_keys(array_keys($fields), NULL);
		}

		return $this->View()->renderSignInForm($post, $errors);
	}

	public function signInRequest($data) {
		if (faf::session()->isStarted() === FALSE) {
			faf::session()->start();
		}
		faf::session()->set('account', [
			'id' => $data['account_id'],
			'type' => $data['account_type'],
			'name' => $data['account_name'],
		]);
		faf::session()->set('authentication', [
			'id' => $data['authentication_id'],
			'email' => $data['authentication_email'],
		]);
		faf::session()->set('authorization', [
			'id' => $data['authorization_id'],
			'name' => $data['authorization_name'],
		]);
	}

	/*
	 * SIGN OUT
	 */
	public function actionSignOut() {
		if (faf::session()->isStarted() === TRUE) {
			faf::session()->end();
		}
		faf::header()->setLocation('/');
	}

	/*
	 * REGISTER
	 */
	public function actionSignUpForm() {
		$fields = [
			'authentication_fake' => TRUE,
//			'account_type_id' => TRUE,
			'account_name' => TRUE,
			'authentication_email' => TRUE,
			'authentication_password' => TRUE,
			'authentication_password_confirm' => TRUE,
		];
		if (faf::request()->method() === 'post') {
			$post = faf::request()->post();
			$this->Model()->load($post)->addValidator('authentication_password', [
				'match' => [
					'pattern' => '[a-zA-Z0-9]{8,16}',
					'message' => 'must be alphanumeric and contain from 8 to 16 symbols',
				],
			])->addValidator('authentication_password_confirm', function () use ($post) {
				return faf::validator()->validateField($post['authentication_password_confirm'], 'set');
			})->addValidator('authentication_password_confirm', function () use ($post) {
				return faf::validator()->validateField($post['authentication_password_confirm'], 'match', [
					'pattern' => '[a-zA-Z0-9]{8,16}',
					'message' => 'must be alphanumeric and contain from 8 to 16 symbols',
				]);
			})->addValidator('authentication_fake', function () {
				return $this->Model()->signUpCheck();
			})->addValidator('authentication_fake', function () use ($post) {
				if ($post['authentication_password'] !== $post['authentication_password_confirm']) {
					return 'Password does not match the confirm password';
				} else {
					return TRUE;
				}
			})->validate();
			$errors = array_merge($fields, $this->Model()->getErrors());
			if ($this->Model()->valid === TRUE) {
				$authentication_registration_code = faf::generator()->unique();
				$account_type_id = $this->Model()->signUpAccountTypeIdGet('modules');
				$authorization_id = $this->Model()->signUpAuthorizationIdGet('modules');
				$this->signUpRequest($account_type_id, $post['account_name'], $post['authentication_email'], $post['authentication_password'],
					$authentication_registration_code, $authorization_id);
				faf::header()->setLocation(faf::router()->urlTo('/authentication/sign-up/request/registration_code', [
					'registration_code' => $authentication_registration_code,
				]));
			}
		} else {
			$post = array_fill_keys(array_keys($fields), NULL);
			$errors = array_fill_keys(array_keys($fields), NULL);
		}

		return $this->View()->renderSignUpForm($post, $errors);
	}

	public function signUpRequest($account_type_id, $account_name, $authentication_email, $authentication_password = NULL, $authentication_registration_code, $authorization_id) {
		if ($authentication_password === NULL) {
			$authentication_password = faf::generator()->password();
		}
		$authentication_password_salt = faf::generator()->salt();
		$this->Model()->signUpRequest($account_name, $account_type_id, $authentication_email, $authentication_password, $authentication_password_salt,
			$authentication_registration_code, $authorization_id);
		$sign_up_data = $this->Model()->signUpGet($authentication_registration_code);
		faf::mailer()->isHTML(TRUE);
		faf::mailer()->setFrom('no-reply@' . faf::request()->host(), faf::$configuration['application']['name']);
		faf::mailer()->addAddress($sign_up_data['authentication_email']);
		faf::mailer()->Subject = 'Registration';
		faf::mailer()->Body = $this->View()->renderSignUpEmail($sign_up_data, $authentication_registration_code, $authentication_password);
		faf::mailer()->send();
	}

	public function actionSignUpFeedback() {
		$registration_code = faf::router()->matches['registration_code'];
		$data = $this->Model()->signUpGet($registration_code);
		if (empty($data) === FALSE) {
			$message = 'You have successfully registered. Please check email we have send to you.';
			$result = $this->View()->renderSignUpFeedback($message);
		} else {
			$message = $this->View()->displayErrorMessage('wrong sign up request code');
			$result = $this->View()->renderSignUpFeedback($message);
		}
		faf::header()->setRefresh(faf::router()->urlTo('/authentication/sign-in'), 5);

		return $result;
	}

	public function actionSignUpConfirm() {
		$registration_code = faf::router()->matches['registration_code'];
		$data = $this->Model()->signUpGet($registration_code);
		if (empty($data) === FALSE) {
			$this->Model()->signUpConfirm($registration_code);
			$this->signInRequest($data);
			$message = 'You have successfully signed up';
			$result = $this->View()->renderSignUpFeedback($message);
			faf::header()->setRefresh(faf::router()->urlTo('/'), 1);
		} else {
			$message = $this->View()->displayErrorMessage('wrong sign up confirm code');
			$result = $this->View()->renderSignUpFeedback($message);
			faf::header()->setRefresh(faf::router()->urlTo('/authentication/sign-in'), 5);
		}

		return $result;
	}

	/*
	 * RESET
	 */
	public function actionResetForm() {
		$fields = [
			'authentication_email' => TRUE,
		];
		if (faf::request()->method() === 'post') {
			$post = faf::request()->post();
			$this->Model()->load($post)->addValidator('authentication_email', function () {
				return $this->Model()->resetCheck();
			})->validate();
			$errors = array_merge($fields, $this->Model()->getErrors());
			if ($this->Model()->valid === TRUE) {
				$password_code = faf::generator()->unique();
				$account_id = $this->Model()->resetByEmailGet($post['authentication_email']);
				$this->resetRequest($account_id, $password_code);
				faf::header()->setLocation(faf::router()->urlTo('/authentication/reset/feedback/password_code', [
					'password_code' => $password_code,
				]));
			}
		} else {
			$post = array_fill_keys(array_keys($fields), NULL);
			$errors = array_fill_keys(array_keys($fields), NULL);
		}

		return $this->View()->renderResetForm($post, $errors);
	}

	public function resetRequest($account_id, $password_code = NULL) {
		if ($password_code === NULL) {
			$password_code = faf::generator()->unique();
		}
		$this->Model()->resetRequest($account_id, $password_code);
		$model = $this->Model()->resetByCodeGet($password_code);
		if ($model !== FALSE) {
			faf::mailer()->isHTML(TRUE);
			faf::mailer()->setFrom('no-reply@' . faf::request()->host(), faf::$configuration['application']['name']);
			faf::mailer()->addAddress($model['authentication_email']);
			faf::mailer()->Subject = 'Password reset request';
			faf::mailer()->Body = $this->View()->renderResetRequestEmail($model['account_name'], $password_code);
			faf::mailer()->send();

			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function actionResetFeedback() {
		$password_code = faf::router()->matches['password_code'];
		$data = $this->Model()->resetByCodeGet($password_code);
		if (empty($data) === FALSE) {
			$message = 'You have requested pasword reset. Please check email we have send to you.';
			$result = $this->View()->renderResetFeedback($message);
		} else {
			$message = $this->View()->displayErrorMessage('wrong password reset request code');
			$result = $this->View()->renderResetFeedback($message);
		}
		faf::header()->setRefresh(faf::router()->urlTo('/authentication/sign-in'), 5);

		return $result;
	}

	public function actionResetConfirm() {
		$password_code = faf::router()->matches['password_code'];
		$data = $this->Model()->resetByCodeGet($password_code);
		if (empty($data) === FALSE) {
			$password = faf::generator()->password();
			$password_salt = faf::generator()->salt();
			$this->Model()->resetConfirm($password, $password_code, $password_salt);
			faf::mailer()->isHTML(TRUE);
			faf::mailer()->setFrom('no-reply@' . faf::request()->host(), faf::$configuration['application']['name']);
			faf::mailer()->addAddress($data['authentication_email']);
			faf::mailer()->Subject = 'Password reset';
			faf::mailer()->Body = $this->View()->renderResetConfirmEmail($data['account_name'], $data['authentication_email'], $password);
			faf::mailer()->send();
			$message = 'You have confirmed pasword reset request. Please check email we have send to you.';
			$result = $this->View()->renderResetFeedback($message);
		} else {
			$message = $this->View()->displayErrorMessage('wrong password reset confirm code');
			$result = $this->View()->renderResetFeedback($message);
		}
		faf::header()->setRefresh(faf::router()->urlTo('/authentication/sign-in'), 5);

		return $result;
	}
}
