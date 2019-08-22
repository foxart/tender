<?php

namespace tender\common\modules\account\views;

use fa\classes\View;
use fa\core\faf;

class AccountIndexView extends View {

	public static $instance;

	public function renderAccount($data) {
		$account_metadata_update = faf::converter()->arrayToMetadata([
			'modal' => '#account-form-update',
			'container' => '#account',
			'title' => 'Edit account',
			'populate' => faf::router()->urlTo('/account/get'),
			'submit' => faf::router()->urlTo('/account/update'),
			'reload' => faf::router()->urlTo('/account/ajax'),
		]);

//		return $this->template()->load('themes/common/templates/account/account.twig')->set([
		return $this->template()->load('application/tender/common/modules/account/templates/account.twig')->set([
			'account_surname' => $data['account_surname'],
			'account_name' => $data['account_name'],
			'account_patronymic' => $data['account_patronymic'],
			'account_type_name' => $data['account_type_name'],
			'authentication_email' => $data['authentication_email'],
			'authorization_name' => $data['authorization_name'],
		])->set([
			'account_form_update' => $this->accountFormUpdate(),
			'account_metadata_update' => $account_metadata_update,
		])->render();
	}

	public function accountFormUpdate() {
		return $this->template()->load('application/tender/common/modules/account/templates/accountFormUpdate.twig')->render();
	}
}
