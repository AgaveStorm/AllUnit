<?php

require_once 'TVmLocVarValue.php';

class TVmLocVar implements ILocVar{
	
	
	
	function getAllPossible($prevs) {
		$slug = reset($prevs)->getSlug();
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$model = $factory->createBySlug($slug);
		$list = $model->getListModel();
		$items = $list->getAll();
		$re = [];
		foreach($items as $item) {
			$re[] = new TVmLocVarValue(
				$item->getId(), 
				$item->getTitle(),
				$model->getTitle()
				);
		}
		return $re;
	}
}
