<?php

require_once 'allunit/core/interface/ILocVarValue.php';

class TVmLocVarValue implements ILocVarValue {
	private $slug;
	private $title;
	private $vmTitle;
	
	public function __construct($slug, $title, $vmTitle) {
		$this->slug = $slug;
		$this->title = $title;
		$this->vmTitle = $vmTitle;
	}
	
	public function getSlug() {
		return $this->slug;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getVmTitle() {
		return $this->vmTitle;
	}
	
	public function __toString() {
		return $this->getSlug();
	}
}
