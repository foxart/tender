<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqMaterialEditModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqMaterialView;

class PurchaserRfqMaterialEditController extends Controller {

	private function Model() {
		return PurchaserRfqMaterialEditModel::instance();
	}

	private function View() {
		return PurchaserRfqMaterialView::instance();
	}

	/*
	 * Material
	 */
	public function actionRfqMaterialSelect() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$material_name = faf::request()->get('query_string');
		$data = $this->Model()->rfqItemMaterialSelect($account['id'], $rfq_id, $material_name);

		return json_encode([
			'items' => $data,
		]);
	}

	public function outputRfqMaterialForm() {
		return $this->View()->renderRfqMaterialForm();
	}

	public function outputRfqMaterialFormDelete() {
		return $this->View()->renderRfqMaterialFormDelete();
	}

	public function actionRfqMaterialGet() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$material_id = faf::router()->matches['material-id'];
		$data = $this->Model()->rfqMaterialGet($account['id'], $rfq_id, $material_id);

		return json_encode($data);
	}

	public function actionRfqMaterialAdd() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$post = faf::request()->post();
		$this->Model()->load($post);
		$material_id = faf::request()->post('material_id');
		$this->Model()->addValidator('material_id', function () {
			if (faf::request()->post('material_id') === NULL) {
				return 'please enter material';
			} else {
				return TRUE;
			}
		})->addValidator('material_id', function () use ($account, $rfq_id, $material_id) {
			$count = $this->Model()->rfqMaterialAddCheck($account['id'], $rfq_id, $material_id);
			if ($count == 0) {
				return TRUE;
			} else {
				return 'material already assigned';
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqMaterialAdd($account['id'], $rfq_id, $material_id);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqMaterialUpdate() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$material_id = faf::router()->matches['material-id'];
		$post = faf::request()->post();
		$this->Model()->load($post)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqMaterialUpdate($account['id'], $rfq_id, $material_id);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqMaterialDelete() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$material_id = faf::router()->matches['material-id'];
		$this->Model()->addValidator('material_name', function () use ($account, $rfq_id, $material_id) {
			$data = $this->Model()->rfqMaterialDeleteCheck($account['id'], $rfq_id, $material_id);
			if (empty($data) === TRUE) {
				return TRUE;
			} else {
				$list = [];
				foreach ($data as $item) {
					$list[] = faf::html()->span([], "<b>[{$item['id']}]</b> {$item['name']}");
				}

				return $this->View()->displayErrorMessage('can`t delete material associated with companies:') . $this->View()
						->displayWarningMessage(implode('<br/>', $list));
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqMaterialDelete($account['id'], $rfq_id, $material_id);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
