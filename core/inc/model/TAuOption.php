<?php


class TAuOption extends TSingle{
	public function getBeanType() {
		return 'auoption';
	}

	public function getFields() {
		return [
		    ['name'=>'name'],
		    ['name'=>'value']
		];
	}

}
