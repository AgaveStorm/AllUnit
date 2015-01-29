<?php

class EMultiidField extends Exception {}

class TMultiidField extends TAuField {
	
	function __construct($params) {
		parent::__construct($params);
		$required = [
		    'list',
		];
		foreach($required as $param) {
			if(empty($this->params[$param])) {
				throw new EMultiidField('Required param '.$param.' is empty');
			}
		}
	}
	
	public function getType() {
		return 'multiid';
	}
	
	public function beforeSet($value) {
		$value = TXml::MakeTree($value,'ids');
		var_dump($value);
		return $value;
	}
}
