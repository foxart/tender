<?php

namespace tender\purchaser\modules\rfq\views;

use fa\classes\View;
use fa\core\faf;

class PurchaserRfqView extends View {

	public static $instance;

	/*
	 * RFQ list
	 */
	public function renderRfqList($data) {
		$rfq_list = [];
		foreach ($data as $key => $value) {
			$rfq_link_delete = faf::html()->a([
				'class' => [
					'glyphicon glyphicon-trash bs-modal-link',
					faf::converter()->arrayToMetadata([
						'title' => 'Delete RFQ',
						'disable' => [],
						'modal' => '#rfq-form',
						'container' => '#rfq_list',
						'populate' => faf::router()->urlTo('/rfq/rfq_id/change/get', [
							'rfq_id' => $value['rfq_id'],
						]),
						'submit' => faf::router()->urlTo('/rfq/rfq_id/change/delete', [
							'rfq_id' => $value['rfq_id'],
						]),
						'reload' => faf::router()->urlTo('/rfq/ajax'),
					]),
				],
				'title' => 'Delete RFQ',
				'href' => '#',
			], NULL);
			$rfq_link_change = faf::html()->a([
				'class' => [
					'glyphicon glyphicon-pencil',
				],
				'title' => 'Change RFQ',
				'href' => faf::router()->urlTo('/rfq/rfq_id/change', [
					'rfq_id' => $value['rfq_id'],
				]),
			], NULL);
			$rfq_link_view = faf::html()->a([
				'title' => 'View',
				'href' => faf::router()->urlTo('/rfq/rfq_id/quotation', [
					'rfq_id' => $value['rfq_id'],
				]),
			], 'View');
			$rfq_list[] = [
				'№' => $value['row'],
				'Reference №' => $value['rfq_id'],
				'Company' => $value['company_name'],
				'Purchase group' => $value['rfq_name'],
				'Rfq publish date' => $value['rfq_date_publish'],
				'Quotation submission last date' => $value['rfq_date_quote'],
				'Question submission last date' => $value['rfq_date_question'],
				'Remarks' => $value['rfq_remark'],
				'Terms' => $value['rfq_term'],
//				'Messenger' => '',
				'Status' => $value['rfq_status'],
				'View vendors quotations' => $rfq_link_view,
				'Action' => faf::html()->set([
					$rfq_link_change,
					$rfq_link_delete,
				]),
			];
		}
		$rfq_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'Create RFQ',
			'modal' => '#rfq-form',
			'container' => '#rfq_list',
			'submit' => faf::router()->urlTo('/rfq/add'),
			'reload' => faf::router()->urlTo('/rfq/ajax'),
		]);

		return $this->template()->load('rfq/purchaserRfqList.twig')->set([
			'rfq_list' => faf::table()->arrayToTable($rfq_list),
		])->set([
			'rfq_metadata_add' => $rfq_metadata_add,
		])->render();
	}

	public function renderRfqListFilter() {
		return $this->template()->load('rfq/purchaserRfqListFilter.twig')->set([])->render();
	}

	/*
	 * RFQ item
	 */
	public function renderRfqForm($model) {
		$rfq_company_id = faf::html()->options($model);

		return $this->template()->load('rfq/purchaserRfqForm.twig')->set([
			'rfq_company_id' => $rfq_company_id,
		])->render();
	}

	public function renderRfqItem($data) {
		$rfq_id = faf::router()->matches('rfq_id');

		return $this->template()->load('rfq/purchaserRfqItem.twig')->set([
			'rfq_id' => $rfq_id,
			'rfq_status' => $data['rfq_status'],
			'rfq_date_publish' => $data['rfq_date_publish'],
			'rfq_date_question' => $data['rfq_date_question'],
			'rfq_date_quote' => $data['rfq_date_quote'],
			'rfq_name' => $data['rfq_name'],
			'rfq_remark' => nl2br($data['rfq_remark']),
			'rfq_term' => nl2br($data['rfq_term']),
			'company_name' => $data['company_name'],
		])->render();
	}

	public function renderRfqItemUpdateLink() {

		$rfq_id = faf::router()->matches('rfq_id');

		$rfq_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'Change RFQ',
			'modal' => '#rfq-form',
//			'disable' => [
//				'rfq_company_id',
//			],
			'container' => '#rfq_item',
			'populate' => faf::router()->urlTo('/rfq/rfq_id/change/get', [
				'rfq_id' => $rfq_id,
			]),
			'submit' => faf::router()->urlTo('/rfq/rfq_id/change/update', [
				'rfq_id' => $rfq_id,
			]),
			'reload' => faf::router()->urlTo('/rfq/rfq_id/change/ajax', [
				'rfq_id' => $rfq_id,
			]),
		]);


//		<a class="btn btn-sm btn-primary pull-right bs-modal-link {{ rfq_metadata_update }}" href="#">Change RFQ</a>

		return faf::html()->a([
			'href'=>[
				'#'
				],
			'class'=>[
				'btn btn-sm btn-primary pull-right bs-modal-link',
				$rfq_metadata_update
			]

		],

			'Change RFQ'
			);


//		return $rfq_metadata_update;

	}
	public function renderRfqItemUrlBack() {
		return faf::router()->urlTo('/rfq');
	}
}
