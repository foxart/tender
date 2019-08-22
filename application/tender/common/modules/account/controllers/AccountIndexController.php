<?php

namespace tender\common\modules\account\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\account\models\AccountIndexModel;
use tender\common\modules\account\views\AccountIndexView;

class AccountIndexController extends Controller {

	private function Model() {
		return AccountIndexModel::instance();
	}

	private function View() {
		return AccountIndexView::instance();
	}

	public function actionAccount() {
		$account = faf::session()->get('account');
		$data = $this->Model()->profile($account['id']);

		return $this->View()->renderAccount($data);
	}

	public function outputAccountBadge() {
		$account = faf::session()->get('account');
		switch ($account['type']) {
			case 'admin':
				$icon_class = 'flaticon-id-card-3';
				$home_url = faf::router()->urlTo('/account');
				break;
			case 'purchaser':
				$icon_class = 'flaticon-user-3';
				$home_url = faf::router()->urlTo('/account');
				break;
			case 'vendor':
//				$icon_class = 'flaticon-folder-13';
				$icon_class = 'flaticon-notebook-4';
				$home_url = faf::router()->urlTo('/account');
				break;
			default:
//				$icon = faf::html()->span([], NULL);
				$icon_class = 'flaticon-key';
				$home_url = faf::router()->urlTo('/');
		}
		$result = faf::html()->set([
			faf::html()->a([
				'class' => 'navbar-brand',
				'style' => 'padding-top: 0px; padding-right: 0px;',
				'href' => $home_url,
			], [
				faf::html()->span([
					'class' => $icon_class,
					'style' => 'height: 40px; width: 40px; font-size: 40px; line-height: 50px;',
				], NULL),
			]),
			'&nbsp;',
			faf::html()->span([
				'style' => 'line-height: 50px; color: #ffffff;',
			], $account['type']),
			faf::html()->span([
//				'class' => 'badge',
				'style' => 'font-weight: bold; color: #ffffff;',
			], "[{$account['id']}]"),
		]);

		return $result;
	}
}
