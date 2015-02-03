<?php

require_once 'TList.php';
require_once 'TActiveUnit.php';

class TActiveUnits extends TList {
	public function getSingleModelName() {
		return 'TActiveUnit';
	}
	
	public function setActive($name, $value) {
		$bean = R::findOne($this->getBeanType(), "name=:name LIMIT 1", array(":name"=>$name));
		if(empty($bean)) {
			$bean = R::dispense($this->getBeanType());
			$bean->name = $name;
		}
		$bean->value = (bool)$value;
		R::store($bean);
	}
		
	public function getActive($name) {
		$bean = R::findOne($this->getBeanType(), "name=:name LIMIT 1", array(":name"=>$name));
		if($bean === null) {
			return null;
		}
		return (bool)$bean->value;
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
	
	public function getActiveSlugs() {
		$list = R::findAll($this->getBeanType(), "`value`='1' GROUP BY name");
		$re = [];
		foreach($list as $item) {
			$re[] = $item->name;
		}
		return $re;
	}
	
	public function getAllAsArray() {
		$list = $this->getAll();
		$re = [];
		foreach($list as $item) {
			$re[] = [
			    'name'=>$item->get('name'),
			    'value'=>$item->get('value')
			];
		}
		return $re;
	}
}
