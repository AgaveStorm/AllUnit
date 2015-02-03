<?php


class TActiveUnit extends TSingle{
	public function getBeanType() {
		return 'activeunit';
	}

	public function getFields() {
		return [
		    ['name'=>'name'],
		    ['name'=>'value']
		];
	}

}
