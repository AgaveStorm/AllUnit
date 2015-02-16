<?php

require_once 'allunit/core/interface/ILocVar.php';
require_once 'TLocVarValue.php';

/**
 * Location var
 * used to determine possible locations
 */
class TLocVar implements ILocVar {
	
	private $slug;
	private $field;
	
	/**
	 * @param $slug view model slug
	 * @param $field model field name, for example 'id' or 'slug'
	 */
	public function __construct($slug, $field) {
		$this->slug = $slug;
		$this->field = $field;
	}
	
	public function getAllPossible() {
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$list = $factory->createBySlug($this->slug)->getListModel();
		$items = $list->getAll();
		$re = [];
		foreach($items as $item) {
			if($this->field == 'id') {
				$re[] = new TLocVarValue(
					$item->getId(), 
					$item->getTitle() 
					);
				continue;
			}
			$re[] = new TLocVarValue(
				$item->get($this->field), 
				$item->getTitle() 
				);
		}
		return $re;
	}
}
