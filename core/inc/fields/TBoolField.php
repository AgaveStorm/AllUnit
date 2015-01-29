<?php

require_once 'allunit/core/interface/IField.php';

class TBoolField extends TAuField implements IField {
	public function getType() {
		return 'bool';
	}
	
	public function beforeSet($value) {
		if($value == 'on') {
			$value = true;
		}
		return (bool)$value;
	}
}