<?php

require_once 'allunit/core/interface/ILocVar.php';

class TVmSlugLocVar implements ILocVar{
	function getAllPossible($prevs) {
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$re = [];
		foreach($factory->getViewModels() as $modelName) {
			$model = new $modelName;
			$re[] = new TLocVarValue(
				$model->getSlug(),
				$model->getTitle()
				);
		}
		return $re;
	}
}
