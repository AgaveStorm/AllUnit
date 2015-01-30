<?php


class TDefaultField extends TAuField implements IField {
	
	public function getType() {
		if(!empty($this->params['type'])) {
			return $this->params['type'];
		}
		return '';
	}
	
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
	
	public function beforeGet($value, $single) {
		if($this->getType() == 'date') {
			return date('d.m.Y', strtotime($value));
		}
		if($this->getType() == 'editor'
			|| $this->getType() == 'text'
			) {
			return htmlspecialchars_decode($value);
		}
		return $value;
	}
	
	public function beforeGetE($value, $single) {
		if($this->getType() == 'date') {
			return date('d.m.Y', strtotime($value));
		}
		if($this->getType() == 'id') {
			$name = $this->getName()."_id";
			$id = $this->bean->$name;
			if(!empty($id)) {
				return $id;
			}
		}
		if($this->getType() == 'text') {
			return TXml::cdata(htmlspecialchars_decode($value));
		}
		return htmlspecialchars_decode($value);
	}
}
