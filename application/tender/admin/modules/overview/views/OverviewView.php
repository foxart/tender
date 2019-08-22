<?php

namespace tender\admin\modules\overview\views;

use fa\classes\View;
use fa\core\faf;

class OverviewView extends View {

	public static $instance;

	public function renderIndexPage() {
//		$account_admin_add_metadata = faf::converter()->arrayToMetadata([
//			'modal' => '#modal-add-user',
//			'container' => '#user-list',
//			'submit' => faf::router()->urlTo('/users/add'),
//			'reload' => faf::router()->urlTo('/users/list'),
//		]);
//		$account_add_button = faf::html()->a([
//			'class' => 'btn btn-block btn-primary btn-sm bs-modal-link ' . $account_admin_add_metadata,
//			'href' => '#',
//		], 'Add');
		return $this->template()->load('overview/index.twig')->set([
			'not_approved_vendors' => $this->renderNotApprovedVendors(),
			'pending_pr' => $this->renderPendingPr(),
			'opened_rfq' => $this->renderOpenedRfq(),
			'opened_po' => $this->renderOpenedPo(),
		])->render();
	}

	public function renderNotApprovedVendors() {
		$table[] = [
			'Vendor name' => '',
			'Date of profile submission' => '',
			'Status' => '',
			'Task assigned to' => '',
		];
		$content = faf::table()->arrayToTable($table);

		return $content;
	}

	public function renderPendingPr() {
		$table[] = [
			'PR Ref No' => '',
			'PR Date' => '',
		];
		$content = faf::table()->arrayToTable($table);

		return $content;
	}

	public function renderOpenedRfq() {
		$table[] = [
			'RFQ No' => '',
			'RFQ Date' => '',
		];
		$content = faf::table()->arrayToTable($table);

		return $content;
	}

	public function renderOpenedPo() {
		$table[] = [
			'PO Ref No' => '',
			'PO Date' => '',
			'Status' => '',
		];
		$content = faf::table()->arrayToTable($table);

		return $content;
	}
}
