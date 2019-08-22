<?php

namespace tender\vendor\modules\contact\views;

use fa\classes\View;
use fa\core\faf;

class ContactIndexView extends View {

	public static $instance;

	public function renderContactItem($contact) {
		$company = faf::router()->matches['company'];
		$company_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'change contact',
			'modal' => '#contact-form-update',
			'container' => '#company_item',
			'populate' => faf::router()->urlTo('/company/company-id/contact/get', [
				'company' => $company,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/contact/update', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/contact/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('contact/contactItem.twig')->set($contact)->set([
			'contact_form_update' => $this->contactFormUpdate(),
			'contact_metadata_update' => $company_metadata_update,
		])->render();
	}

	public function contactFormUpdate() {
		return $this->template()->load('contact/contactFormUpdate.twig')->render();
	}

	public function renderContactItemAdd() {
		$company = faf::router()->matches['company'];
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add contact',
			'modal' => '#contact-form-add',
			'container' => '#company_item',
			'submit' => faf::router()->urlTo('/company/company-id/contact/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/contact/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('contact/contactItemAdd.twig')->set([
			'contact_form_add' => $this->contactFormAdd(),
			'contact_metadata_add' => $company_metadata_add,
			'message' => $this->displayWarningMessage('add contact details'),
		])->render();
	}

	public function contactFormAdd() {
		return $this->template()->load('contact/contactFormAdd.twig')->render();
	}
}
