<?php


class TDateField extends TAuField {
	function beforeSet($value, $single) {
		$single->castSqlType($this->getName(),'date');
		return date('Y-m-d',strtotime($value)); //@todo magick
	}
	function beforeGet($value, $single) {
		return date('d.m.Y',strtotime($value)); //@todo magick
	}
}
