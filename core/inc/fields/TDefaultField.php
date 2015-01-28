<?php


class TDefaultField extends TField implements IField {
	public function beforeSet($value, $single) {
		$type = $this->getType();
		if($type == 'passwd') {
			$value = sha1($value); // hash passwords
		}
		if($type == 'multiid') {
			$value = TXml::MakeTree($value,'ids');
		}
		if($type == 'date') {
			$value = date('Y-m-d', strtotime($value));
			$single->bean->setMeta('cast.'.$name,'date');
		}
		return $value;
	}
}
