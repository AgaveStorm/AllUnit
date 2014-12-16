<?php


class TBkUser extends TSingle {
	public function getBeanType() {
		return 'tbkuser';
	}

	public function getFields() {
		return [
		    ['name'=>'login', 'title'=>'Login'],
		    ['name'=>'password', 'title'=>'Password','type'=>'password']
		];
	}

	function hasBackendAccess() {
		return true; //@todo magick
	}
}
