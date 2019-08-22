<?php

namespace tender\admin\modules\role\views;

use fa\classes\View;
use fa\core\faf;

class AuthorizationView extends View {

	public static $instance;

	public function renderIndexPage($authorization_list, $account_type_list) {
		$authorization_add_button_metadata = faf::converter()->arrayToMetadata([
			'modal' => '#authorization-form',
			'container' => '#authorization-list',
			'title' => 'Add role',
			'submit' => faf::router()->urlTo('/settings/authorization/add'),
			'reload' => faf::router()->urlTo('/settings/authorization/ajax'),
		]);

		return $this->template()->load('setting/authorization/index.twig')->set([
			'authorization_list' => $this->renderAuthorizationList($authorization_list),
			'modal_form' => $this->renderModalForm($account_type_list),
			'authorization_add_button' => faf::html()->a([
				'class' => 'btn btn-block btn-primary btn-sm bs-modal-link ' . $authorization_add_button_metadata,
				'href' => '#',
			], 'Add'),
		])->render();
	}

	public function renderModalForm($account_type_list) {
		$account_type_option = faf::html()->options($account_type_list);

		return $this->template()->load('setting/authorization/authorizationForm.twig')->set([
			'account_type_option' => $account_type_option,
		])->render();
	}

	public function renderAuthorizationList($company_list) {
		$table = array();
		if (empty($company_list) === FALSE) {
			foreach ($company_list as $key => $value) {
				$authorization_update_button_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#authorization-form',
					'container' => '#authorization-list',
					'title' => 'Edit role',
					'disable' => [
						'authorization_account_type_id',
					],
					'populate' => faf::router()
						->urlTo('/settings/authorization/authorization-id/get', ['authorization-id' => $value['authorization_id']]),
					'submit' => faf::router()
						->urlTo('/settings/authorization/authorization-id/update', ['authorization-id' => $value['authorization_id']]),
					'reload' => faf::router()->urlTo('/settings/authorization/ajax'),
				]);
				$authorization_delete_button_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#authorization-form',
					'container' => '#authorization-list',
					'title' => 'Delete company',
					'disable' => [],
					'populate' => faf::router()
						->urlTo('/settings/authorization/authorization-id/get', ['authorization-id' => $value['authorization_id']]),
					'submit' => faf::router()
						->urlTo('/settings/authorization/authorization-id/delete', ['authorization-id' => $value['authorization_id']]),
					'reload' => faf::router()->urlTo('/settings/authorization/ajax'),
				]);
				switch ($value['account_type_name']) {
					case 'admin':
						$account_type_name = faf::html()->span(['class' => 'label label-danger',], $value['account_type_name']);
						break;
					case 'purchaser':
						$account_type_name = faf::html()->span([
							'class' => 'label label-success',
						], $value['account_type_name']);
						break;
					case 'vendor':
						$account_type_name = faf::html()->span([
							'class' => 'label label-info',
						], $value['account_type_name']);
						break;
					default:
						$account_type_name = faf::html()->span(['class' => 'label label-default',], '(not set)');
						break;
				}
				$table[] = [
					"№" => $value['row'],
					"account type" => $account_type_name,
					"role" => $value['authorization_name'],
					'action' => faf::html()->a([
							'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $authorization_update_button_metadata,
							'title' => 'Edit',
							'href' => '#',
						], '') . '&nbsp;' . faf::html()->a([
							'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $authorization_delete_button_metadata,
							'title' => "Delete",
							'href' => '#',
						], ''),
				];
			}
			$content = faf::table()->arrayToTable($table);
		} else {
			$content = $this->displayWarningMessage('add role');
		}

		return $content;
	}
}
