<?php


class TPage {
	private $slug;
	private $title;
	private $locvar;
	
	public function __construct($slug, $title, $locvar = null) {
		$this->slug = $slug;
		$this->title = $title;
		$this->locvar = $locvar;
	}
	public function getSlug() {
		return $this->slug;
	}
	
	public function getSlugStr() {
		return @implode("/",$this->slug);
	}
	
	public function getLocVar() {
		return $this->locvar;
	}
	
	function getTitle() {
		return $this->title;
	}
}
