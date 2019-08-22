<?php

namespace tender\admin\modules\account\profile\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\profile\models\AdminAccountProfileEditModel;
use tender\common\modules\authentication\controllers\AuthenticationController;

class AdminAccountProfileEditController extends Controller {

	private $EditController;

	/**
	 * @return AdminAccountProfileEditModel
	 */
	private function Model() {
		return AdminAccountProfileEditModel::instance();
	}

	/**
	 * @return AuthenticationController
	 */
	private function AuthenticationController() {
		if (isset($this->EditController[__METHOD__]) === FALSE) {
			$this->EditController[__METHOD__] = new AuthenticationController();
		}

		return $this->EditController[__METHOD__];
	}

	public function actionAccountGet() {
		$account_id = faf::router()->matches['account-id'];

		return json_encode($this->Model()->accountGet($account_id));
	}

	/**
	 * Update account for the user Admin
	 *
	 * @return string
	 */
	public function actionAccountUpdate() {
		if (faf::request()->method() === 'post') {
			$this->Model()->load(faf::request()->post());
			$account_id = faf::router()->matches['account-id'];
			$this->Model()->addLoad([
				'account_id' => $account_id,
			]);
			$this->Model()->validate();
			if ($this->Model()->valid === TRUE) {
				$result = $this->Model()->accountUpdate();
			} else {
				$result = $this->Model()->errorsToJson();
			}
		} else {
			$result = json_encode($this->Model()->accountGet(faf::router()->matches['account-id']));
		};

		return $result;
	}

	public function actionActiveStatusAccount() {
		$account_id = faf::router()->matches['account-id'];
		$this->Model()->addValidator('fake_validation_message', function () use ($account_id) {
			if ($this->Model()->activeStatusUpdateCheck($account_id) === TRUE) {
				return TRUE;
			} else {
				return 'you can\'t switch your account status';
			}
		});
		$this->Model()->validate();
		if ($this->Model()->valid === TRUE) {
			if (faf::request()->method() === 'post') {
				$account = $this->Model()->account($account_id);
				if ($account['authentication_active'] === 'true') {
					$this->Model()->addLoad([
						'account_id' => $account_id,
						'authentication_active' => 'false',
					]);
				} else {
					$this->Model()->addLoad([
						'account_id' => $account_id,
						'authentication_active' => 'true',
					]);
				}
				$this->Model()->activeStatusUpdate();
			};
		} else {
			return $this->Model()->errorsToJson();
		}

		return TRUE;
	}

	public function actionResetPassword() {
		$this->Model()->addLoad([
			'account_id' => faf::router()->matches['account-id'],
		]);
		$this->Model()->addValidator('fake_validation_message', function () {
			$result = $this->Model()->registeredStatusCheck();
			if ($result === TRUE) {
				return TRUE;
			} else {
				return 'this account didn\'t confirm registration';
			}
		});
		$this->Model()->validate();
		if ($this->Model()->valid === TRUE) {
			$result = $this->AuthenticationController()->resetRequest(faf::router()->matches['account-id']);
		} else {
			$result = $this->Model()->errorsToJson();
		}

		return $result;
	}

	public function accountAuthorizationUpdate() {
		$authorization_id = faf::request()->post('authorization_id', [
			'empty' => 0,
		]);
		$this->Model()->accountAuthorizationUpdate(faf::router()->matches['account-id'], $authorization_id);

		return TRUE;
	}
}
