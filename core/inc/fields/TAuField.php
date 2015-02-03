<?php

require_once 'allunit/core/interface/IField.php';

class TAuField implements IField {
	public function __construct($params) {
		TAuFields::add($this);
		$this->params = $params;
	}

	public function getName() {
		return $this->params['name'];
	}
	public function getType() {
		if(!empty($this->params['type'])) {
			return $this->params['type'];
		}
		return get_class($this);
	}
	public function getTitle() {
		if(!empty($this->params['title'])) {
			return $this->params['title'];
		}
		return $this->getName();
	}
	
	/**
	 * @deprecated
	 */
	public function get($param) {
		return $this->params[$param];
	}
	
	public function asArray() {
		return array_merge($this->params,[
		    'name'=>$this->getName(),
		    'type'=>$this->getType(),
		    'title'=>$this->getTitle(),
		]);
	}
	
	public function GetTemplate() {
		return TConfigManager::GetTemplate(get_class($this));
	}
	
	public function beforeSet($value, $single) {
		return $value;
	}
	public function beforeGet($value, $single) {
		return $value;
	}
	public function beforeGetE($value, $single) {
		return $this->beforeGet($value, $single);
	}
}
