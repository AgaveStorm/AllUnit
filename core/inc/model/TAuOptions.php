<?php

require_once 'TList.php';
require_once 'TAuOption.php';

class EAuNoSuchOption extends Exception {};

class TAuOptions extends TList {
	public function getSingleModelName() {
		return 'TAuOption';
	}
	public function getPossibleOptions() {
		return [
		     ['name'=>'siteTitle', 'title'=>'Site Title'],
		     ['name'=>'author', 'title'=>'Author'],
		     ['name'=>'minifyCss','title'=>'Minify CSS', 'type'=>'bool'],
		     ['name'=>'minifyJs','title'=>'Minify Js', 'type'=>'bool'],
		     ['name'=>'metaKeywords', 'title'=>'Default Meta Keywords'],
		     ['name'=>'metaDescription', 'title'=>'Default Meta Description', 'type'=>'textarea'],
		     ['name'=>'developersEye','title'=>'Show developers eye (debug)', 'type'=>'bool'],
		];
	}
	
	public function setOption($name, $value) {
		$bean = R::findOne($this->getBeanType(), "name=:name LIMIT 1", array(":name"=>$name));
		if(empty($bean)) {
			$bean = R::dispense($this->getBeanType());
			$bean->name = $name;
		}
		$option = $this->getOptionParamsByName($name);
		
		if($option['type'] == 'bool') {
//			var_dump($option);
//			var_dump($value);
			$value = (bool)$value;
		}
		$bean->value = $value;
		R::store($bean);
	}
	
	public function getOptionParamsByName($name) {
		foreach($this->getPossibleOptions() as $option) {
			if($option['name'] == $name) {
				return $option;
			}
		}
		throw new EAuNoSuchOption();
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
