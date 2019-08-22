<?php

namespace tender\purchaser\modules\profile\views;

use fa\classes\View;
use fa\core\faf;

class PurchaserProfileIndexView extends View {

	public static $instance;

	public function renderVendorCompanyList($data) {
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = [
				'№' => $value['row'],
//				'account name' => $value['vendor_name'],
				'company code' => $value['vendor_company_id'],
				'company title' => $value['vendor_company_title'],
				'company type' => $value['vendor_company_type'],
				'company name' => faf::html()->span([
						'class' => 'glyphicon glyphicon-folder-open',
					], '&nbsp;') . faf::html()->a([
						'title' => 'Edit',
						'href' => faf::router()->urlTo('/profile/purchaser_company_id/vendor_company_id', [
							'purchaser_company_id' => $value['purchaser_company_id'],
							'vendor_company_id' => $value['vendor_company_id'],
						]),
					], $value['vendor_company_name']),
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('no associated vendors');
		} else {
			$table = faf::table()->arrayToTable($result);
		}

		return $this->template()->load('profile/purchaserProfileVendorCompanyList.twig')->set([
			'table' => $table,
		])->render();
	}

	public function renderVendorCompany($data) {
		return $this->template()->load('profile/purchaserProfileVendorCompanyItem.twig')->set([
			'company_code' => $data['company_id'],
			'company_name' => $data['company_name'],
			'company_type' => $data['company_type'],
			'company_title' => $data['company_title'],
			'excise_tax' => $data['excise_tax'],
			'excise_basis' => $data['excise_basis'],
			'excise_registration' => $data['excise_registration'],
			'excise_registration_number' => $data['excise_registration_number'],
			'excise_service' => $data['excise_service'],
			'excise_service_number' => $data['excise_service_number'],
			'excise_sales' => $data['excise_sales'],
			'excise_sales_number' => $data['excise_sales_number'],
			'excise_license' => $data['excise_license'],
			'detail_country' => $data['detail_country'],
			'detail_region' => $data['detail_region'],
			'detail_city' => $data['detail_city'],
			'detail_postal' => $data['detail_postal'],
			'detail_district' => $data['detail_district'],
			'detail_street' => $data['detail_street'],
			'detail_house' => $data['detail_house'],
			'detail_email' => $data['detail_email'],
			'detail_phone' => $data['detail_phone'],
			'factory_country' => $data['factory_country'],
			'factory_region' => $data['factory_region'],
			'factory_city' => $data['factory_city'],
			'factory_postal' => $data['factory_postal'],
			'factory_district' => $data['factory_district'],
			'factory_street' => $data['factory_street'],
			'factory_house' => $data['factory_house'],
			'factory_email' => $data['factory_email'],
			'factory_phone' => $data['factory_phone'],
			'contact_person' => $data['contact_person'],
			'contact_title' => $data['contact_title'],
			'contact_position' => $data['contact_position'],
			'contact_email' => $data['contact_email'],
			'contact_phone' => $data['contact_phone'],
			'back_url' => faf::router()->urlTo('/profile'),
		])->render();
	}

	public function renderVendorBankList($data) {
//		return Debugger::dump($data, TRUE);
//		return faf::table()->arrayToTable($data);
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = [
				'№' => $value['row'],
				'key' => $value['key'],
				'account' => $value['account'],
				'holder' => $value['holder'],
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('no bank details');
		} else {
			$table = faf::table()->arrayToTable($result);
		}

		return $this->template()->load('profile/purchaserProfileVendorCompanyItemBankList.twig')->set([
			'table' => $table,
			'back_url' => faf::router()->urlTo('/profile'),
		])->render();
	}

	public function renderVendorMaterialList($data) {
//		return Debugger::dump($data, TRUE);
//		return faf::table()->arrayToTable($data);
		$result = array();
		foreach ($data as $key => $value) {
			if ($value['material_file'] !== NULL) {
				$file = faf::html()->span([
						'class' => 'glyphicon glyphicon-file',
					], '&nbsp;') . faf::html()->a([
						'class' => 'fa-js-blank',
						'title' => 'Edit',
						'href' => faf::router()->urlTo('/files', [
							'file' => $value['material_file'],
						]),
					], $value['material_title']);
			} else {
				$file = $value['material_title'];
			}
			$result[] = [
				'№' => $value['row'],
				'group' => $value['material_group_name'],
				'material' => $value['material_name'],
				'uom' => $value['material_uom'],
				'description' => $value['material_description'],
				'po' => nl2br($value['material_po']),
				'file' => $file,
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('no company materials');
		} else {
			$table = faf::table()->arrayToTable($result);
		}

		return $this->template()->load('profile/purchaserProfileVendorCompanyItemMaterialList.twig')->set([
			'table' => $table,
			'back_url' => faf::router()->urlTo('/profile'),
		])->render();
	}
}
