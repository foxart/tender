<?php

namespace tender\admin\modules\account\user\controllers;

use fa\classes\Controller;

use fa\core\faf;
use tender\admin\modules\account\user\models\AdminAccountUserEditModel;
use tender\common\modules\authentication\controllers\AuthenticationController;

class AdminAccountUserEditController extends Controller {

	private $EditController;

	/**
	 * @return AdminAccountUserEditModel
	 */
	private function Model() {
		return AdminAccountUserEditModel::instance();
	}

	/**
	 * @return string
	 */
	public function actionAccountGet() {
		return json_encode($this->Model()->accountGet(faf::router()->matches['account-id']));
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

	/**
	 * Register new account by Admin
	 *
	 * @return string
	 */
	public function actionAddAccount() {
		$this->Model()->load(faf::request()->post());
		$this->Model()->addValidator('authentication_email', function () {
			if ($this->Model()->addAccountCheck() === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		});
		$this->Model()->validate();
		if ($this->Model()->valid === TRUE) {
			$post = faf::request()->post();
			$this->AuthenticationController()->signUpRequest($post['account_type_id'], $post['account_name'], $post['authentication_email'], NULL,
				faf::generator()->unique('admin_'), 0);
			$result = TRUE;
		} else {
			$result = $this->Model()->errorsToJson();
		}

		return $result;
	}

	public function actionDeleteAccount() {
		$result = FALSE;
		if (faf::request()->method() === 'post') {
			$this->Model()->load(faf::request()->post());
			$account_id = faf::router()->matches['account-id'];
			$this->Model()->addLoad([
				'account_id' => $account_id,
			]);
			$this->Model()->addValidator('delete_user_fake', function () {
				$account = faf::session()->get('account');
				if (faf::router()->matches['account-id'] != $account['id']) {
					return TRUE;
				} else {
					return 'you can\'t delete self account';
				}
			});
			$this->Model()->validate();
			if ($this->Model()->valid === TRUE) {
				$this->AuthenticationController()->deleteRequest($account_id);
				$result = TRUE;
			} else {
				$result = $this->Model()->errorsToJson();
			}
		}

		return $result;
	}
}
