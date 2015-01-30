<?php


class TTimeField extends TAuField {
	function beforeSet($value, $single) {
		$single->castSqlType($this->getName(),'datetime');
		return date('0000-00-00 H:i:s',strtotime($value));
	}
	function beforeGet($value, $single) {
		return date('H:i',strtotime($value));
	}
}
