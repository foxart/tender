<?php

namespace tender\vendor\modules\factory\views;

use fa\classes\View;
use fa\core\faf;

class IndexView extends View {

	public static $instance;

	public function renderFactoryItem($company) {
		$id = faf::router()->matches['company'];
		$factory_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'Add factory details',
			'modal' => '#factory-form-update',
			'container' => '#company_factory',
			'populate' => faf::router()->urlTo('/company/company-id/factory/get', [
				'company' => $id,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/factory/update', [
				'company' => $id,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/factory/ajax', [
				'company' => $id,
			]),
		]);

		return $this->template()->load('factory/factoryItem.twig')->set($company)->set([
			'factory_form_update' => $this->renderFactoryFormUpdate(),
			'factory_metadata_update' => $factory_metadata_update,
		])->render();
	}

	public function renderFactoryItemAdd() {
		$company = faf::router()->matches['company'];
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'Change factory details',
			'modal' => '#factory-form-add',
			'container' => '#company_factory',
			'submit' => faf::router()->urlTo('/company/company-id/factory/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/factory/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('factory/factoryItemAdd.twig')->set([
			'factory_form_add' => $this->renderFactoryFormAdd(),
			'factory_metadata_add' => $company_metadata_add,
			'message' => $this->displayWarningMessage('add company factory'),
		])->render();
	}

	public function renderFactoryFormAdd() {
		return $this->template()->load('factory/factoryFormAdd.twig')->set([
			'geo_country_url' => faf::router()->urlTo('/geo/country'),
			'geo_region_url' => faf::router()->urlTo('/geo/region'),
			'geo_city_url' => faf::router()->urlTo('/geo/city'),
		])->render();
	}

	public function renderFactoryFormUpdate() {
		return $this->template()->load('factory/factoryFormUpdate.twig')->set([
			'geo_country_url' => faf::router()->urlTo('/geo/country'),
			'geo_region_url' => faf::router()->urlTo('/geo/region'),
			'geo_city_url' => faf::router()->urlTo('/geo/city'),
		])->render();
	}
}
