<?php

require_once 'allunit/core/inc/model/TSingle.php';
require_once 'allunit/core/inc/model/TList.php';
require_once 'VBaseModel.php';

abstract class TBaseViewModelFactory {
	
	abstract public function getViewModels();
	
	/**
	 * @param $filename string file name of IViewModelFactory implementation ( the latest child? njt this abstract class )
	 */
	public function includeViewModels($filename) {
		$exploded = explode(DIRECTORY_SEPARATOR,$filename);
		if(count($exploded)>0) {
			unset($exploded[count($exploded)-1]);
		} else {
			$exploded = [];
		}
		$path = implode(DIRECTORY_SEPARATOR, $exploded);
		$list = $this->getViewModels();
		foreach($list as $class) {
			$file = $path."/".$class.".php";
			if(file_exists($file)) {
				require_once $file;
			}
		}
		
	}
	//abstract public function getReports();

	public function createBySlug($slug) {
		foreach($this->getViewModels() as $model) {
			if($model::getSlug() == $slug) {
				return new $model();
			}
		}
	}
        
        public function createByBean($bean) {
                foreach($this->getViewModels() as $modelName) {
                        $model = new $modelName();
			if($model->getBean() == $bean) {
				return $model;
			}
		}
        }
}
