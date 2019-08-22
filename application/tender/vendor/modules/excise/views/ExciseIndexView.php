<?php

namespace tender\vendor\modules\excise\views;

use fa\classes\View;
use fa\core\faf;
use tender\vendor\modules\excise\models\ExciseIndexModel;

class ExciseIndexView extends View {

	public static $instance;

	private function IndexModel() {
		return ExciseIndexModel::instance();
	}

	public function renderExciseItem($excise) {
		$company = faf::router()->matches['company'];
		$excise_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'change excise tax',
			'modal' => '#excise-form-update',
			'container' => '#company_item',
			'populate' => faf::router()->urlTo('/company/company-id/excise/get', [
				'company' => $company,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/excise/update', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/excise/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('excise/exciseItem.twig')->set([
			'excise_tax' => $excise['excise_tax'],
			'excise_basis' => $excise['excise_basis'],
			'excise_registration' => $excise['excise_registration'],
			'excise_registration_number' => $excise['excise_registration_number'],
			'excise_sales' => $excise['excise_sales'],
			'excise_sales_number' => $excise['excise_sales_number'],
			'excise_service' => $excise['excise_service'],
			'excise_service_number' => $excise['excise_service_number'],
			'excise_license' => $excise['excise_license'],
		])->set([
			'excise_form_update' => $this->renderExciseFormUpdate(),
			'excise_metadata_update' => $excise_metadata_update,
		])->render();
	}

	public function renderExciseItemAdd() {
		$company = faf::router()->matches['company'];
		$excise_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add excise tax',
			'modal' => '#excise-form-add',
			'container' => '#company_item',
			'submit' => faf::router()->urlTo('/company/company-id/excise/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/excise/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('excise/exciseItemAdd.twig')->set([
			'excise_form_add' => $this->renderExciseFormAdd(),
			'excise_metadata_add' => $excise_metadata_add,
			'message' => $this->displayWarningMessage('add excise tax'),
		])->render();
	}

	public function renderExciseFormAdd() {
		$excise = $this->IndexModel()->exciseExciseEnum();
		$excise_list = array();
		foreach ($excise as $item) {
			$excise_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_registration',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$excise_radio = implode('', $excise_list);
		//
		$sales = $this->IndexModel()->exciseSalesEnum();
		$sales_list = array();
		foreach ($sales as $item) {
			$sales_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_sales',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$sales_radio = implode('', $sales_list);
		//
		$service = $this->IndexModel()->exciseServiceEnum();
		$service_list = array();
		foreach ($service as $item) {
			$service_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_service',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$service_radio = implode('', $service_list);
		$excise_basis_option = faf::html()->options($this->IndexModel()->exciseBasisList());
		$excise_tax_option = faf::html()->options($this->IndexModel()->exciseTaxList());

		return $this->template()->load('excise/exciseFormAdd.twig')->set([
			'excise_radio' => $excise_radio,
			'sales_radio' => $sales_radio,
			'service_radio' => $service_radio,
			'excise_basis_option' => $excise_basis_option,
			'excise_tax_option' => $excise_tax_option,
		])->render();
	}

	public function renderExciseFormUpdate() {
		$excise = $this->IndexModel()->exciseExciseEnum();
		$excise_list = array();
		foreach ($excise as $item) {
			$excise_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_registration',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$excise_radio = implode('', $excise_list);
		//
		$sales = $this->IndexModel()->exciseSalesEnum();
		$sales_list = array();
		foreach ($sales as $item) {
			$sales_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_sales',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$sales_radio = implode('', $sales_list);
		//
		$service = $this->IndexModel()->exciseServiceEnum();
		$service_list = array();
		foreach ($service as $item) {
			$service_list[] = faf::html()->label([
				'class' => 'radio-inline',
			], faf::html()->input([
					'name' => 'excise_service',
					'type' => 'radio',
					'value' => $item,
				], $item) . '&nbsp;&nbsp;&nbsp;');
		}
		$service_radio = implode('', $service_list);
		$excise_basis_option = faf::html()->options($this->IndexModel()->exciseBasisList());
		$excise_tax_option = faf::html()->options($this->IndexModel()->exciseTaxList());

		return $this->template()->load('excise/exciseFormUpdate.twig')->set([
			'excise_radio' => $excise_radio,
			'sales_radio' => $sales_radio,
			'service_radio' => $service_radio,
			'excise_basis_option' => $excise_basis_option,
			'excise_tax_option' => $excise_tax_option,
		])->render();
	}
}
