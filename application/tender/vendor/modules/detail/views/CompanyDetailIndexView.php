<?php

namespace tender\vendor\modules\detail\views;

use fa\classes\View;
use fa\core\faf;

class CompanyDetailIndexView extends View {

	public static $instance;

	public function renderDetailItem($detail) {
		$id = faf::router()->matches['company'];
		$detail_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'Change company details',
			'modal' => '#detail-form-update',
			'container' => '#company_detail',
			'populate' => faf::router()->urlTo('/company/company-id/detail/get', [
				'company' => $id,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/detail/update', [
				'company' => $id,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/detail/ajax', [
				'company' => $id,
			]),
		]);

		return $this->template()->load('detail/detailItem.twig')->set($detail)->set([
			'detail_form_update' => $this->renderDetailFormUpdate(),
			'detail_metadata_update' => $detail_metadata_update,
		])->render();
	}

	public function renderDetailItemAdd() {
		$company = faf::router()->matches['company'];
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'Add company details',
			'modal' => '#detail-form-add',
			'container' => '#company_detail',
			'submit' => faf::router()->urlTo('/company/company-id/detail/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/detail/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('detail/detailItemAdd.twig')->set([
			'detail_form_add' => $this->renderDetailFormAdd(),
			'detail_metadata_add' => $company_metadata_add,
			'message' => $this->displayWarningMessage('add company detail'),
		])->render();
	}

	public function renderDetailFormAdd() {
		return $this->template()->load('detail/detailFormAdd.twig')->set([
			'geo_country_url' => faf::router()->urlTo('/geo/country'),
			'geo_region_url' => faf::router()->urlTo('/geo/region'),
			'geo_city_url' => faf::router()->urlTo('/geo/city'),
		])->render();
	}

	public function renderDetailFormUpdate() {
		return $this->template()->load('detail/detailFormUpdate.twig')->set([
			'geo_country_url' => faf::router()->urlTo('/geo/country'),
			'geo_region_url' => faf::router()->urlTo('/geo/region'),
			'geo_city_url' => faf::router()->urlTo('/geo/city'),
		])->render();
	}
}
