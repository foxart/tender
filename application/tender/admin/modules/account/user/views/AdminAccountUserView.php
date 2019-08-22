<?php

namespace tender\admin\modules\account\user\views;

use fa\classes\View;
use fa\core\faf;

class AdminAccountUserView extends View {

	public static $instance;

	/**
	 * @param $users
	 * @param $account_type
	 *
	 * @return string
	 */
	public function renderAccountList($users, $account_type) {
		$table = array();
		if (empty($users) === FALSE) {
			foreach ($users as $key => $value) {
				$user_delete_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#modal-delete-user',
					'container' => '#user-list',
					'title' => 'Delete user',
					'populate' => faf::router()->urlTo("/users/ajax", [
						'account-id' => $value['account_id'],
					]),
					'submit' => faf::router()->urlTo("/users/delete", [
						'account-id' => $value['account_id'],
					]),
					'reload' => faf::router()->urlTo("/users/list"),
				]);
				switch ($value['account_type_name']) {
					case 'admin':
						$user_url = faf::router()->urlTo('/users/admin/account-id', [
							'account-id' => $value['account_id'],
						]);
						$account_type_name = faf::html()->span(['class' => 'label label-danger',], $value['account_type_name']);
						break;
					case 'purchaser':
						$user_url = faf::router()->urlTo('/users/purchaser/account-id', [
							'account-id' => $value['account_id'],
						]);
						$account_type_name = faf::html()->span([
							'class' => 'label label-success',
						], $value['account_type_name']);
						break;
					case 'vendor':
						$user_url = faf::router()->urlTo('/users/vendor/account-id', [
							'account-id' => $value['account_id'],
						]);
						$account_type_name = faf::html()->span([
							'class' => 'label label-info',
						], $value['account_type_name']);
						break;
					default:
						$user_url = '#';
						$account_type_name = faf::html()->span(['class' => 'label label-default',], $value['account_type_name']);
						break;
				}
				if ($value['authentication_active'] == 'true') {
					$authentication_active = faf::html()->span(['class' => 'label label-success',], 'Yes');
				} else {
					$authentication_active = faf::html()->span(['class' => 'label label-danger',], 'No');
				}
				if (empty($value['authentication_registration_code']) === TRUE) {
					$authentication_registration_code = faf::html()->span(['class' => 'label label-success',], 'Yes');
				} else {
					$authentication_registration_code = faf::html()->span(['class' => 'label label-danger',], 'No');
				}
				$table[] = [
					'№' => $value['row'],
					'registration date' => $value['authentication_registration_date'],
					"email" => faf::html()->span([
							'class' => 'glyphicon glyphicon-folder-open',
						], '&nbsp;') . faf::html()->a([
							'title' => 'Edit',
							'href' => $user_url,
						], $value['authentication_email']),
					'name' => $value['account_name'],
					"active" => $authentication_active,
					"type" => $account_type_name,
					'role' => $value['authorization_name'],
					'registered' => $authentication_registration_code,
					"delete" => faf::html()->a([
						'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $user_delete_metadata,
						'href' => '#',
					], ''),
				];
			}
			$content = faf::table()->arrayToTable($table);
		} else {
			$content = $this->displayWarningMessage('Create user');
		}
		$account_admin_add_metadata = faf::converter()->arrayToMetadata([
			'modal' => '#form-add-user',
			'container' => '#user-list',
			'title' => 'Add user',
//			'populate' => faf::router()->urlTo("/users/ajax", [
//				'account-id' => '24',
//			]),
			'submit' => faf::router()->urlTo('/users/add'),
			'reload' => faf::router()->urlTo('/users/list'),
		]);

		return $this->template()->load('account/user/index.twig')->set([
			'add_account_metadata' => $account_admin_add_metadata,
			'account_admin_form_add' => $this->renderFormAddAccount($account_type),
			'account_admin_form_delete' => $this->renderFormDeleteAccount(),
			'content' => $content,
		])->render();
	}

	public function renderFormAddAccount($user_group) {

//		dump($user_group);
//		exit;
//		$user_role_options = '';
//		if (empty($user_group) === FALSE) {
//			foreach ($user_group as $value) {
//				$user_role_options .= faf::html()->option([
//					'value' => $value['account_type_id'],
//					'label' => $value['account_type_name'],
//				], $value['account_type_name']);
//			}
//		}

		return $this->template()->load('account/user/accountFormAdd.twig')->set([
//			'account_type_options' => $user_role_options,
			'account_type_options' => faf::html()->options($user_group),
		])->render();
	}

	public function renderFormDeleteAccount() {
		$result = $this->template()->load('account/user/accountFormDelete.twig')->render();

		return $result;
	}

	/**
	 * @param null $user_group
	 *
	 * @return string
	 */
	public function renderFormUserListFilter($user_group = NULL) {
//		todo-artyom submit и reload маршруты одинаковые - исправить
		$account_filter_metadata = faf::converter()->arrayToMetadata([
			'container' => '#user-list',
			'title' => '',
			'submit' => faf::router()->urlTo('/users/list'),
			'reload' => faf::router()->urlTo('/users/list'),
		]);
//		$user_role_options = '';
//		if (empty($user_group) === FALSE) {
//			foreach ($user_group as $value) {
//				$user_role_options .= faf::html()->option([
//					'value' => $value['account_type_id'],
//					'label' => $value['account_type_name'],
//					'selected' => $value['account_type_id'] == faf::request()->get('account_type_id_filter') ? 'selected' : '',
//				], $value['account_type_name']);
//			}
//		}
		$result = $this->template()->load('account/user/accountFormListFlter.twig')->set([
//			'user_group' => $user_role_options,
			'user_group' => faf::html()->options($user_group),
//			'user_name_value'=>faf::request()->get('account_name_filter'),
			'account_filter_metadata' => $account_filter_metadata,
//			'submit_url' => faf::router()->urlTo('/users'),
		])->render();

		return $result;
	}
}
