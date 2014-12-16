<?php

require_once 'TList.php';
require_once 'TAuOption.php';

class TAuOptions extends TList {
	public function getSingleModelName() {
		return 'TAuOption';
	}
	public function getPossibleOptions() {
		return [
		     ['name'=>'siteTitle', 'title'=>'Site Title'],
		     ['name'=>'author', 'title'=>'Author'],
		];
	}
	
	public function setOption($name, $value) {
		$bean = R::findOne($this->getBeanType(), "name=:name LIMIT 1", array(":name"=>$name));
		if(empty($bean)) {
			$bean = R::dispense($this->getBeanType());
			$bean->name = $name;
		}
		$bean->value = $value;
		R::store($bean);
	}
	
	public function getOption($name) {
		$bean = R::findOne($this->getBeanType(), "name=:name LIMIT 1", array(":name"=>$name));
		return $bean->value;
	}
	
	public function getAll() {
		$list = R::findAll($this->getBeanType(), "GROUP BY name");
		$re = [];
		foreach($list as $item) {
			$class = $this->getSingleModelName();
			$re[] = new $class($item);
		}
		return $re;
	}
	
	public function getAllAsArray() {
		$list = $this->getAll();
		$re = [];
		foreach($list as $item) {
			$re[] = $item->getDataAsArray();
		}
		return $re;
	}
}
