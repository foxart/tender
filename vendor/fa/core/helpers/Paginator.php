<?php
/*
 * foxart
 */
//29.10.2009
//03.11.2009
//19:41 26.11.2009
//11:26 21.05.2010
//2:36 23.02.2011
//3:43 23.02.2011
//23:41 04.05.2011
//23:34 16.06.2012
namespace fa\core\helpers;

use fa\core\classes\Singleton;

class Paginator extends Singleton {

	/**
	 * @var static <p>reference to the <i>Singleton</i> instance of class</p>
	 */
	public static $instance;

	public function onConstruct() {
		parent::onConstruct();
		// public function __construct() {
		// $this->page_pattern = rawurlencode('|PAGE|');
		$this->page_pattern = '{{ page }}';
		$this->min_rows = 2;
		$this->max_rows = 1000;
		$this->order = 'asc';
	}

	public function output($url = '#') {
		if ($this->page_last == 1) {
			return;
		}
		echo self::_output($url);
	}

	private function _output($url) {
		$paginatorTpl = '<div class="fa_paginator">|PAGINATOR|</div>';
		$firstTpl = '<span class="_left"><span class="_page _first"><a class="fa_link" href="|FIRST_URL|">|FIRST_TITLE|</a></span></span>';
		$prevLeftTpl = '<span class="_left"><span class="_page _prev_end"><a class="fa_link" href="|PREV_URL|">|PREV_TITLE|</a></span></span>';
		$prevTpl = '<span class="_page _prev"><a class="fa_link" href="|PREV_URL|">|PREV_TITLE|</a></span>';
		$nextTpl = '<span class="_page _next"><a class="fa_link" href="|NEXT_URL|">|NEXT_TITLE|</a></span>';
		$nextRightTpl = '<span class="_right"><span class="_page _next_end"><a class="fa_link" href="|NEXT_URL|">|NEXT_TITLE|</a></span></span>';
		$lastTpl = '<span class="_right"><span class="_page _last"><a class="fa_link" href="|LAST_URL|">|LAST_TITLE|</a></span></span>';
		$currentTpl = '<span class="_page _current">|CURRENT|</span>';
		$commonTpl = '<span class="_page _common"><a class="fa_link" href="|URL|">|TITLE|</a></span>';
		$separatorTpl = '<span class="_page _break">|SEPARATOR|</span>';
//		$this->text_first = '';
//		$this->text_prev = '';
//		$this->text_next = '';
//		$this->text_last = '';
//		$this->text_separator = '';
		ob_start();
		if ($this->page_current != $this->page_first) {
			echo str_replace(array(
				'|FIRST_TITLE|',
				'|FIRST_URL|',
			), array(
				@$this->text_first,
				self::_fetch_url(@$this->page_first, $url),
			), $firstTpl);
			echo str_replace(array(
				'|PREV_TITLE|',
				'|PREV_URL|',
			), array(
				@$this->text_prev,
				self::_fetch_url(@$this->page_current - 1, $url),
			), $prevLeftTpl);
		}
		if ($this->page_current > $this->page_first + $this->offset_left + $this->offset_center + 1) {
			// echo str_replace(array('|PREV_TITLE|', '|PREV_URL|'), array($this->text_prev, self::_fetch_url($this->page_current - 1, $url)), $prevLeftTpl);
		}
		foreach ($this->pages as $key => $value) {
			switch ($value) {
				case 0:
					echo str_replace('|SEPARATOR|', $this->text_separator, $separatorTpl);
					break;
				case $this->page_current:
					if ($this->page_current < $this->page_last - $this->offset_right - $this->offset_center - 1 and $this->page_current > $this->page_first + $this->offset_left + $this->offset_center + 1) {
						$prevnext = TRUE;
					} else {
						$prevnext = FALSE;
					}
					if ($prevnext) {
						echo str_replace(array(
							'|PREV_TITLE|',
							'|PREV_URL|',
						), array(
							$this->text_prev,
							self::_fetch_url($this->page_current - 1, $url),
						), $prevTpl);
					}
					echo str_replace('|CURRENT|', $value, $currentTpl);
					if ($prevnext) {
						echo str_replace(array(
							'|NEXT_TITLE|',
							'|NEXT_URL|',
						), array(
							$this->text_next,
							self::_fetch_url($this->page_current + 1, $url),
						), $nextTpl);
					}
					break;
				default:
					echo str_replace(array(
						'|URL|',
						'|TITLE|',
					), array(
						self::_fetch_url($key, $url),
						$value,
					), $commonTpl);
			}
		}
		if ($this->page_current < $this->page_last - $this->offset_right - $this->offset_center - 1) {
			// echo str_replace(array('|NEXT_TITLE|', '|NEXT_URL|'), array($this->text_next, self::_fetch_url($this->page_current + 1, $url)), $nextRightTpl);
		}
		if ($this->page_current != $this->page_last) {
			echo str_replace(array(
				'|NEXT_TITLE|',
				'|NEXT_URL|',
			), array(
				$this->text_next,
				self::_fetch_url($this->page_current + 1, $url),
			), $nextRightTpl);
			echo str_replace(array(
				'|LAST_TITLE|',
				'|LAST_URL|',
			), array(
				$this->text_last,
				self::_fetch_url($this->page_last, $url),
			), $lastTpl);
		}

		return str_replace('|PAGINATOR|', ob_get_clean(), $paginatorTpl);
	}

	private function _fetch_url($page, $url) {
		if ($this->order == 'desc') {
			$page = $this->page_last - $page + 1;
		}

		return str_replace($this->page_pattern, $page, $url);
	}

	public function getOffset($page, $count, $limit) {
		$page_last = ceil($count / $limit);
//		echo $page;
//		echo $page_last;
		if ($page < 1 or $count < 1) {
			$page = 1;
		} elseif ($page > $page_last) {
			$page = $page_last;
		}
		$result = ($page - 1) * $limit;

		return $result;
	}

	/* */
	public function render($page, $count, $limit, $url, $options = array()) {
		if (empty($options) === TRUE) {
			$options = array(
				'group' => array(
					3,
					3,
					3,
				),
				'text' => array(
					'<<',
					'<',
					'...',
					'>',
					'>>',
				),
			);
		}
		self::initialize($options['group'], $options['text']);
		self::create($page, $count, $limit);
		$result = self::parse($url);

		return $result;
	}

	public function initialize($group = array(), $text = array()) {
//		$groupIndex = array('offset_left', 'offset_center', 'offset_right');
//		$textIndex = array('text_first', 'text_prev', 'text_separator', 'text_next', 'text_last');
		$this->text_first = '<<';
		$this->text_prev = '<';
		$this->text_separator = '...';
		$this->text_next = '>';
		$this->text_last = '>>';
		$this->offset_left = 3;
		$this->offset_center = 3;
		$this->offset_right = 3;
//view($group);
//view($text);
		foreach ($group as $key => $value) {
//			$this->$groupIndex[$key] = $value;
		}
		foreach ($text as $key => $value) {
//			$this->$textIndex[$key] = htmlspecialchars($value);
		}
	}

	/* */
	/* PRIVATE */
	public function create($page, $rows_total, $rows_per_page, $order = 'asc') {
		if ($rows_per_page > $this->max_rows) {
			$rows_per_page = $this->max_rows;
		}
		if ($rows_per_page < $this->min_rows) {
			$rows_per_page = $this->min_rows;
		}
		if ($rows_total < 1) {
			$rows_total = 1;
		}
		$this->order = $order;
		$this->page_first = 1;
		$this->page_last = ceil($rows_total / $rows_per_page);
//		$page = (int) $page;
		if (strtolower($this->order) == 'asc') {
			if ($page == 0) {
				$this->page_current = $this->page_first;
			} else {
				$this->page_current = $page;
			}
		}
		if (strtolower($this->order) == 'desc') {
			if ($page == 0) {
				$page = $this->page_last;
			}
			$this->page_current = $this->page_last - $page + 1;
		}
		if ($this->page_current < 1) {
			$this->page_current = 1;
		} elseif ($this->page_current > $this->page_last) {
			$this->page_current = $this->page_last;
		}
		$this->limit = $rows_per_page;
		$this->offset = ($this->page_current - 1) * $this->limit;
		self::_create($this->page_current, $this->page_last);
	}

	private function _create($page_current, $page_last) {
//		$this->offset_left = 0;
//		$this->offset_center = 0;
//		$this->offset_right = 0;
		$this->pages = array();
		$left = $this->page_first + $this->offset_left + $this->offset_center + 1;
		$right = $this->page_last - $this->offset_right - $this->offset_center - 1;
		$index = 1;
		if ($left < $this->page_current) {
			/* MIDDLE LEFT */
			for ($i = $this->page_first; $i <= $this->page_first + $this->offset_left; $i++) {
				$index = self::_store($index, $i);
			}
			$index = self::_store($index, 0);
			for ($i = $this->page_current - $this->offset_center; $i <= $this->page_current - 1; $i++) {
				$index = self::_store($index, $i);
			}
		} else {
			/* LEFT */
			for ($i = $this->page_first; $i <= $this->page_current - 1; $i++) {
				$index = self::_store($index, $i);
			}
		}
		$index = self::_store($index, $this->page_current);
		if ($right > $this->page_current) {
			/* MIDDLE RIGHT */
			for ($i = $this->page_current + 1; $i <= $this->page_current + $this->offset_center; $i++) {
				$index = self::_store($index, $i);
			}
			$index = self::_store($index, 0);
			for ($i = $this->page_last - $this->offset_right; $i <= $this->page_last; $i++) {
				$index = self::_store($index, $i);
			}
		} else {
			/* RIGHT */
			for ($i = $this->page_current + 1; $i <= $this->page_last; $i++) {
				$index = self::_store($index, $i);
			}
		}
	}

	private function _store($key, $value) {
		if ($value == 0) {
			$index = $key;
		} else {
			$index = $value;
		}
		$this->pages[$index] = $value;
		$index++;

		return $index;
	}

	public function parse($url = '#') {
		if ($this->page_last == 1) {
			return NULL;
		}

		return self::_output($url);
	}
}
