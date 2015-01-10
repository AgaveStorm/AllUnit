<?php

require_once 'allunit/core/inc/viewModel/TBaseViewModelFactory.php';

class TViewModelFactory extends TBaseViewModelFactory {
	public function getViewModels() {
		return TViewModels::getList();
//		[
//		    'VSchema',
//		    'VSheet',
//		    'VPath',
//		    'VField',
//		];
	}

}
