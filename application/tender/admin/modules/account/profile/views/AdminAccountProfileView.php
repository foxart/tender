<?php

namespace tender\admin\modules\account\profile\views;

use fa\classes\View;
use fa\core\faf;

class AdminAccountProfileView extends View {

	public static $instance;

	public function renderProfileItem($account, $authorization_list) {
		switch ($account['account_type_name']) {
			case 'admin':
				$account_metadata_active = faf::converter()->arrayToMetadata([
					'title' => $account['authentication_active'] == 'true' ? 'Block account' : 'Unblock account',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/admin/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/admin/account-id/active_status', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/admin/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_update = faf::converter()->arrayToMetadata([
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/admin/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/admin/account-id/update', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/admin/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_authorization = faf::converter()->arrayToMetadata([
					'modal' => '#form-authorization',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/admin/account-id/get_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/admin/account-id/update_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/admin/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_reset_password = faf::converter()->arrayToMetadata([
					'title' => 'Reset password',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/admin/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/admin/account-id/reset_password', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/admin/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				break;
			case 'purchaser':
				$account_metadata_active = faf::converter()->arrayToMetadata([
					'title' => $account['authentication_active'] == 'true' ? 'Block account' : 'Unblock account',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/purchaser/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/purchaser/account-id/active_status', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/purchaser/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_update = faf::converter()->arrayToMetadata([
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/purchaser/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/purchaser/account-id/update', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/purchaser/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_authorization = faf::converter()->arrayToMetadata([
					'modal' => '#form-authorization',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/purchaser/account-id/get_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/purchaser/account-id/update_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/purchaser/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_reset_password = faf::converter()->arrayToMetadata([
					'title' => 'Reset password',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/purchaser/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/purchaser/account-id/reset_password', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/purchaser/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				break;
			case 'vendor':
				$account_metadata_active = faf::converter()->arrayToMetadata([
					'title' => $account['authentication_active'] == 'true' ? 'Block account' : 'Unblock account',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/vendor/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/vendor/account-id/active_status', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/vendor/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_update = faf::converter()->arrayToMetadata([
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/vendor/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/vendor/account-id/update', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/vendor/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_authorization = faf::converter()->arrayToMetadata([
					'modal' => '#form-authorization',
					'container' => '#account-profile',
					'title' => 'Edit profile',
					'populate' => faf::router()->urlTo('/users/vendor/account-id/get_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/vendor/account-id/update_authorization', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/vendor/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				$account_metadata_reset_password = faf::converter()->arrayToMetadata([
					'title' => 'Reset password',
					'disable' => [],
					'modal' => '#form-profile',
					'container' => '#account-profile',
					'populate' => faf::router()->urlTo('/users/vendor/account-id/get', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'submit' => faf::router()->urlTo('/users/vendor/account-id/reset_password', [
						'account-id' => faf::router()->matches['account-id'],
					]),
					'reload' => faf::router()->urlTo('/users/vendor/account-id/ajax', [
						'account-id' => faf::router()->matches['account-id'],
					]),
				]);
				break;
			default:
				$account_metadata_authorization = '';
				$account_metadata_active = '';
				$account_metadata_update = '';
				$account_metadata_reset_password = '';
		}
		if ($account['authentication_active'] == 'true') {
			$authentication_active_status = faf::html()->span(['class' => 'label label-success',], 'Yes');
			$account_active_status_button = faf::html()->a([
				'class' => 'btn text-danger bs-modal-link ' . $account_metadata_active,
				'href' => '#',
				'title' => 'block',
			], faf::html()->span([
				'class' => 'flaticon-lock',
				'style' => 'font-size: 30px;',
			], ''));
		} else {
			$authentication_active_status = faf::html()->span(['class' => 'label label-danger',], 'No');
			$account_active_status_button = faf::html()->a([
				'class' => 'btn text-success bs-modal-link ' . $account_metadata_active,
				'href' => '#',
				'title' => 'unblock',
			], faf::html()->span([
				'class' => 'flaticon-lock-1',
				'style' => 'font-size: 30px;',
			], ''));
		}

		return $this->template()->load('account/profile/accountItem.twig')->set([
			'account_active_status_button' => $account_active_status_button,
			'account_metadata_authorization' => $account_metadata_authorization,
			'account_metadata_update' => $account_metadata_update,
			'account_metadata_reset_password' => $account_metadata_reset_password,
			'authentication_active' => $authentication_active_status,
			'account_surname' => $account['account_surname'],
			'account_name' => $account['account_name'],
			'account_patronymic' => $account['account_patronymic'],
			'authentication_email' => $account['authentication_email'],
			'form_profile' => $this->renderFormProfile(),
			'form_authorization' => $this->renderFormAuthorization($authorization_list),
			'account_type_name' => $account['account_type_name'],
			'authorization_name' => $account['authorization_name'],
			'back_url' => faf::router()->urlTo('/users'),
		])->render();
	}

	public function renderFormProfile() {
		$result = $this->template()->load('account/profile/accountForm.twig')->render();

		return $result;
	}

	public function renderFormAuthorization($authorization_list) {
		$authorization_list_option = faf::html()->options($authorization_list);
		$result = $this->template()->load('account/profile/accountFormAuthorization.twig')->set([
			'authorization_option' => $authorization_list_option,
		])->render();

		return $result;
	}

	public function renderErrorPage() {
		return $this->displayErrorMessage('ERROR');
	}
}
