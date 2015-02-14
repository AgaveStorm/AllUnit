<?php

require_once 'allunit/core/interface/ILocVarValue.php';

class TLocVarValue  implements ILocVarValue {
	private $slug;
	private $title;
	
	public function __construct($slug, $title) {
		$this->slug = $slug;
		$this->title = $title;
	}
	
	public function getSlug() {
		return $this->slug;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function __toString() {
		return $this->getSlug();
	}
}
