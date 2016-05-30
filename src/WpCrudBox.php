<?php

namespace wpcrud;

/**
 * Contains info about one of the categories or "boxes".
 */
class WpCrudBox {

	private $title;
	private $fields=array();

	/**
	 * Constructor.
	 */
	public function __construct($title) {
		$this->title=$title;
	}

	/**
	 * Add field to this box.
	 */
	public function addField($fieldId) {
		if ($this->fields[$fieldId])
			throw new Exception("Field already added.");

		$this->fields[$fieldId]=new WpCrudFieldSpec($fieldId);

		return $this->fields[$fieldId];
	}

	/**
	 * Get field ids.
	 */
	public function getFieldIds() {
		return array_keys($this->fields);
	}

	/**
	 * Get field spec.
	 */
	public function getFieldSpec($fieldId) {
		return $this->fields[$fieldId];
	}
}