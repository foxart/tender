<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;
use fa\core\faf;

class Html extends Singleton {

	public static $instance;

	private function getCommonAttributes() {
		$attributes = [
			'accesskey' => 'paired',
			'class' => 'paired',
			'dir' => 'paired',
			'id' => 'paired',
			'lang' => 'paired',
			'style' => 'paired',
			'tabindex' => 'paired',
			'title' => 'paired',
		];

		return $attributes;
	}

	private function getMarkupAttributes($markup) {
		$attributes = array(
			'html 4.01 strict' => [],
			'html 4.01 loose' => [],
			'html 4.01 frameset' => [],
			'html 5.0' => [
				'contenteditable' => 'paired',
				'contextmenu' => 'paired',
				'hidden' => 'single',
				'spellcheck' => 'paired',
			],
			'xhtml 1.0 strict' => [
				'xml:lang' => 'paired',
			],
			'xhtml 1.0 transitional' => [
				'xml:lang' => 'paired',
			],
			'xhtml 1.0 frameset' => [
				'xml:lang' => 'paired',
			],
			'xhtml 1.1' => [
				'xml:lang' => 'paired',
			],
		);

		return $attributes[$markup];
	}

	private function getAttributesOfTagA($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'coords' => 'paired',
				'href' => 'paired',
				'hreflang' => 'paired',
				'name' => 'paired',
				'rel' => 'paired',
				'rev' => 'paired',
				'shape' => 'paired',
				'target' => 'paired',
				'type' => 'paired',
			),
			'html 5.0' => array(
				'download' => 'single',
				'href' => 'paired',
				'hreflang' => 'paired',
				'name' => 'paired',
				'rel' => 'paired',
				'target' => 'paired',
				'type' => 'paired',
			),
			'xhtml 1.0' => array(
				'coords' => 'paired',
				'href' => 'paired',
				'hreflang' => 'paired',
				'name' => 'paired',
				'rel' => 'paired',
				'rev' => 'paired',
				'shape' => 'paired',
				'target' => 'paired',
				'type' => 'paired',
			),
			'xhtml 1.1' => array(
				'coords' => 'paired',
				'href' => 'paired',
				'hreflang' => 'paired',
				'name' => 'paired',
				'rel' => 'paired',
				'rev' => 'paired',
				'shape' => 'paired',
				'type' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function getAttributesOfTagUl($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'type' => 'paired',
			),
			'html 5.0' => array(
				'type' => 'paired',
			),
			'xhtml 1.0' => array(
				'type' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function getAttributesOfTagLi($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'type' => 'paired',
				'value' => 'paired',
			),
			'html 5.0' => array(
				'type' => 'paired',
				'value' => 'paired',
			),
			'xhtml 1.0' => array(
				'type' => 'paired',
				'value' => 'paired',
			),
			'xhtml 1.1' => array(
				'type' => 'paired',
				'value' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function getAttributesOfTagLabel($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'accesskey' => 'paired',
				'for' => 'paired',
			),
			'html 5.0' => array(
				'accesskey' => 'paired',
				'for' => 'paired',
			),
			'xhtml 1.0' => array(
				'accesskey' => 'paired',
				'for' => 'paired',
			),
			'xhtml 1.1' => array(
				'accesskey' => 'paired',
				'for' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function getAttributesOfTagOption($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'disabled' => 'single',
				'label' => 'paired',
				'selected' => 'single',
				'value' => 'paired',
			),
			'html 5.0' => array(
				'disabled' => 'single',
				'label' => 'paired',
				'selected' => 'single',
				'value' => 'paired',
			),
			'xhtml 1.0' => array(
				'disabled' => 'paired',
				'label' => 'paired',
				'selected' => 'paired',
				'value' => 'paired',
			),
			'xhtml 1.1' => array(
				'disabled' => 'paired',
				'label' => 'paired',
				'selected' => 'paired',
				'value' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function _getMarkupForm($markup) {
		$attributes = array(
			'html 4.01' => array(
				'accept-charset' => 'paired',
				'action' => 'paired',
				'enctype' => 'paired',
				'method' => 'paired',
				'name' => 'paired',
				'target' => 'paired',
			),
			'html 5.0' => array(
				'accept-charset' => 'paired',
				'action' => 'paired',
				'autocomplete' => 'paired',
				'enctype' => 'paired',
				'method' => 'paired',
				'name' => 'paired',
				'novalidate' => 'single',
				'target' => 'paired',
			),
			'xhtml 1.0' => array(
				'accept-charset' => 'paired',
				'action' => 'paired',
				'enctype' => 'paired',
				'method' => 'paired',
				'target' => 'paired',
			),
			'xhtml 1.1' => array(
				'accept-charset' => 'paired',
				'action' => 'paired',
				'enctype' => 'paired',
				'method' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function getAttributesOfTagInput($markup) {
		$attributes = array(
			'html 4.01 strict' => array(
				'accept' => 'paired',
				'alt' => 'paired',
				'checked' => 'single',
				'disabled' => 'single',
				'maxlength' => 'paired',
				'name' => 'paired',
				'readonly' => 'single',
				'size' => 'paired',
				'src' => 'paired',
				'type' => 'paired',
				'value' => 'paired',
			),
			'html 5.0' => array(
				'accept' => 'paired',
				'alt' => 'paired',
				'autocomplete' => 'paired',
				'autofocus' => 'single',
				'checked' => 'single',
				'disabled' => 'single',
				'form' => 'paired',
				'formaction' => 'paired',
				'formenctype' => 'paired',
				'formmethod' => 'paired',
				'formnovalidate' => 'single',
				'formtarget' => 'paired',
				'list' => 'paired',
				'max' => 'paired',
				'maxlength' => 'paired',
				'min' => 'paired',
				'multiple' => 'single',
				'name' => 'paired',
				'pattern' => 'paired',
				'placeholder' => 'paired',
				'readonly' => 'single',
				'required' => 'single',
				'size' => 'paired',
				'src' => 'paired',
				'step' => 'paired',
				'type' => 'paired',
				'value' => 'paired',
			),
			'xhtml 1.0' => array(
				'accept' => 'paired',
				'alt' => 'paired',
				'checked' => 'paired',
				'disabled' => 'paired',
				'maxlength' => 'paired',
				'name' => 'paired',
				'readonly' => 'paired',
				'size' => 'paired',
				'src' => 'paired',
				'type' => 'paired',
				'value' => 'paired',
			),
			'xhtml 1.1' => array(
				'accept' => 'paired',
				'alt' => 'paired',
				'checked' => 'paired',
				'disabled' => 'paired',
				'maxlength' => 'paired',
				'name' => 'paired',
				'readonly' => 'paired',
				'size' => 'paired',
				'src' => 'paired',
				'type' => 'paired',
				'value' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function _getMarkupTextarea($markup) {
		$attributes = array(
			'html 4.01' => array(
				'cols' => 'paired',
				'disabled' => 'single',
				'name' => 'paired',
				'readonly' => 'single',
				'rows' => 'paired',
			),
			'html 5.0' => array(
				'autofocus' => 'single',
				'cols' => 'paired',
				'disabled' => 'single',
				'form' => 'paired',
				'maxlength' => 'paired',
				'name' => 'paired',
				'placeholder' => 'paired',
				'readonly' => 'single',
				'required' => 'paired',
				'rows' => 'paired',
				'wrap' => 'paired',
			),
			'xhtml 1.0' => array(
				'cols' => 'paired',
				'disabled' => 'paired',
				'name' => 'paired',
				'readonly' => 'paired',
				'rows' => 'paired',
			),
			'xhtml 1.1' => array(
				'cols' => 'paired',
				'disabled' => 'paired',
				'name' => 'paired',
				'readonly' => 'paired',
				'rows' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	private function _getMarkupSelect($markup) {
		$attributes = array(
			'html 4.01' => array(
				'disabled' => 'single',
				'multiple' => 'single',
				'name' => 'paired',
				'size' => 'paired',
			),
			'html 5.0' => array(
				'autofocus' => 'single',
				'disabled' => 'single',
				'form' => 'paired',
				'multiple' => 'single',
				'name' => 'paired',
				'required' => 'single',
				'size' => 'paired',
			),
			'xhtml 1.0' => array(
				'disabled' => 'paired',
				'multiple' => 'paired',
				'name' => 'paired',
				'size' => 'paired',
			),
			'xhtml 1.1' => array(
				'disabled' => 'paired',
				'multiple' => 'paired',
				'name' => 'paired',
				'size' => 'paired',
			),
		);
		$result = $attributes[$markup];

		return $result;
	}

	/*
	 * PUBLIC
	 */
	public function getAttributesOfTag($tag, $markup) {
		if ($markup === NULL) {
			$markup = faf::$configuration['markup'];
		}
		switch ($tag) {
			case 'div':
				$attributes_by_tag = $this->getCommonAttributes();
				break;
			case 'span':
				$attributes_by_tag = $this->getCommonAttributes();
				break;
			case 'a':
				$attributes_by_tag = $this->getAttributesOfTagA($markup);
				break;
			case 'ul':
				$attributes_by_tag = $this->getAttributesOfTagUl($markup);
				break;
			case 'li':
				$attributes_by_tag = $this->getAttributesOfTagLi($markup);
				break;
			case 'form':
				$attributes_by_tag = $this->_getMarkupForm($markup);
				break;
			case 'label':
				$attributes_by_tag = $this->getAttributesOfTagLabel($markup);
				break;
			case 'select':
				$attributes_by_tag = $this->_getMarkupSelect($markup);
				break;
			case 'option':
				$attributes_by_tag = $this->getAttributesOfTagOption($markup);
				break;
			case 'input':
				$attributes_by_tag = $this->getAttributesOfTagInput($markup);
				break;
			case 'textarea':
				$attributes_by_tag = $this->_getMarkupTextarea($markup);
				break;
			default:
				throw new \Exception("unknown tag: {$tag}");
				break;
		}
//		$attributes_by_markup = $this->getMarkupAttributes($markup);
//		$result = array_merge($attributes_by_markup, $attributes_by_tag);
		$result = $attributes_by_tag + $this->getMarkupAttributes($markup) + $this->getCommonAttributes();

		return $result;
	}

	private function fillAttributes($compare, $against) {
		$attributes = array();
		foreach ($compare as $key => $value) {
			if (array_key_exists($key, $against) === TRUE) {
				if (is_array($value) === TRUE) {
					$attribute = implode(' ', $value);
				} else {
					$attribute = $value;
				}
				if ($against[$key] === 'paired') {
					$attributes[] = "{$key}=\"{$attribute}\"";
				} else {
					$attributes[] = $attribute;
				}
			} else {
				throw new \Exception("wrong attribute: {$key}=\"{$value}\"");
			}
		}
		$result = implode(' ', $attributes);

		return $result;
	}

	private function buildTag($tag, $attributes, $text, $markup = NULL) {
		$filled_attributes = $this->fillAttributes($attributes, $this->getAttributesOfTag($tag, $markup));
		if ($text === NULL) {
//			$tag_text = '&nbsp';
			$tag_text = '';
		} else {
			if (is_array($text) === TRUE) {
				$tag_text = implode(PHP_EOL, $text);
			} else {
				$tag_text = $text;
			}
		}

		return "<{$tag} {$filled_attributes}>{$tag_text}</{$tag}>";
	}

	public function set($set) {
		return implode(PHP_EOL, $set);
	}

	public function span($attributes, $text, $markup = NULL) {
		return $this->buildTag('span', $attributes, $text, $markup);
	}

	public function div($attributes, $text, $markup = NULL) {
		return $this->buildTag('div', $attributes, $text, $markup);
	}

	public function a($attributes, $text, $markup = NULL) {
		return $this->buildTag('a', $attributes, $text, $markup);
	}

	public function label($attributes, $text, $markup = NULL) {
		return $this->buildTag('label', $attributes, $text, $markup);
	}

	public function input($attributes, $text, $markup = NULL) {
		return $this->buildTag('input', $attributes, $text, $markup);
	}

	public function options($options, $markup = NULL) {
		$array = array();
		foreach ($options as $option) {
			$array[] = $this->option([
				'value' => $option['id'],
			], $option['name'], $markup);
		}
		$result = implode(PHP_EOL, $array);

		return $result;
	}

	public function option($attributes, $text, $markup = NULL) {
		return $this->buildTag('option', $attributes, $text, $markup);
	}

	public function ul($attributes, $text, $markup = NULL) {
		return $this->buildTag('ul', $attributes, $text, $markup);
	}

	public function li($attributes, $text, $markup = NULL) {
		return $this->buildTag('li', $attributes, $text, $markup);
	}
}
