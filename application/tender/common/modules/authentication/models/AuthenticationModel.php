<?php

namespace tender\common\modules\authentication\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AuthenticationModel extends SqlModel {

	public static $instance;
//	public static $path = 'application/tender/common/modules/authentication/sql/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'account_name' => [
				'set',
			],
			'authentication_email' => [
				'set',
				'email',
			],
			'authentication_password' => [
				'set',
//				'match' => [
//					'pattern' => '[a-zA-Z0-9]{8,16}',
//					'message' => 'must be alphanumeric and contain from 8 to 16 symbols',
//				],
			],
		];
	}

	public function delete($account_id) {
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationDelete.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->statement;
	}

	public function activeCheck() {
		$count = $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationActiveCheck.sql')->execute()->fetchRow('count');
		if ($count == 1) {
			return TRUE;
		} else {
			return 'account is blocked';
		}
	}

	/*
	 * SIGN IN
	 */
	public function signInCheck() {
		$count = $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignInCheck.sql')->execute()->fetchRow('count');
		if ($count == 1) {
			return TRUE;
		} else {
			return 'wrong credentials';
		}
	}

	public function signInGet() {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignInGet.sql')->execute()->fetchRow();
	}

	/*
	 * SIGN UP
	 */
	public function signUpCheck() {
		$count = $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpCheck.sql')->execute()->fetchRow('count');
		if ($count == 0) {
			return TRUE;
		} else {
			return 'email already registered';
		}
	}

	public function signUpAccountTypeIdGet($account_type_name) {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpAccountTypeIdGet.sql')->prepare([
			'account_type_name' => $account_type_name,
		])->execute()->fetchRow('account_type_id');
	}

	public function signUpAuthorizationIdGet($authorization_name) {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpAuthorizationIdGet.sql')->prepare([
			'authorization_name' => $authorization_name,
		])->execute()->fetchRow('authorization_id');
	}

	public function signUpRequest($account_name, $account_type_id, $authentication_email, $authentication_password, $authentication_password_salt, $authentication_registration_code, $authorization_id) {
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpRequestAuthentication.sql')->prepare([
			'authentication_email' => $authentication_email,
			'authentication_password' => $authentication_password,
			'authentication_password_salt' => $authentication_password_salt,
			'authentication_registration_code' => $authentication_registration_code,
		])->execute();
		$authentication_id = $this->last_insert_id;
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpRequestAccount.sql')->prepare([
			'account_type_id' => $account_type_id,
			'authentication_id' => $authentication_id,
			'authorization_id' => $authorization_id,
			'account_name' => $account_name,
		])->execute();
	}

	public function signUpGet($registration_code) {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpGet.sql')->prepare([
			'authentication_registration_code' => $registration_code,
		])->execute()->fetchRow();
	}

	public function signUpConfirm($registration_code) {
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationSignUpConfirm.sql')->prepare([
			'authentication_registration_code' => $registration_code,
		])->execute();
	}

	/*
	 * PASSWORD RESET
	 */
	public function resetCheck() {
		$count = $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationResetCheck.sql')->execute()->fetchRow('count');
		if ($count == 0) {
			return 'wrong email';
		} else {
			return TRUE;
		}
	}

	public function resetByCodeGet($password_code) {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationResetByCodeGet.sql')->prepare([
			'authentication_password_code' => $password_code,
		])->execute()->fetchRow();
	}

	public function resetByEmailGet($authentication_email) {
		return $this->loadQuery('application/tender/common/modules/authentication/sql/authenticationResetByEmailGet.sql')->prepare([
			'authentication_email' => $authentication_email,
		])->execute()->fetchRow('account_id');
	}

	public function resetRequest($account_id, $password_code) {
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationResetRequest.sql')->prepare([
			'account_id' => $account_id,
			'authentication_password_code' => $password_code,
		])->execute();
	}

	public function resetConfirm($password, $password_code, $password_salt) {
		$this->loadQuery('application/tender/common/modules/authentication/sql/authenticationResetConfirm.sql')->prepare([
			'authentication_password' => $password,
			'authentication_password_code' => $password_code,
			'authentication_password_salt' => $password_salt,
		])->execute();
	}
}


