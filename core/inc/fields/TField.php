<?php


class TField {
	public function __construct($params) {
		TFields::add($this);
		$this->params = $params;
	}

	public function getName() {
		return $this->params['name'];
	}
	public function getType() {
		return $this->params['type'];
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
		return $this->param[$param];
	}
	
	public function asArray() {
		return array_merge($this->params,[
		    'name'=>$this->getName(),
		    'type'=>$this->getType(),
		    'title'=>$this->getTitle(),
		]);
	}
	
	public function GetTemplate() {
		$template =  TConfigManager::GetTemplate(get_class($this));
		return $template;
	}
	
	public function beforeSet($value) {
		return $value;
	}
}
