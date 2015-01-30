<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TDateTimeField
 *
 * @author Yoreck
 */
class TDateTimeField extends TAuField {
	function beforeSet($value, $single) {
		$single->castSqlType($this->getName(),'datetime');
		return date('Y-m-d H:i:s',strtotime($value));
	}
	function beforeGet($value, $single) {
		return date('d.m.Y H:i',strtotime($value));
	}
}
