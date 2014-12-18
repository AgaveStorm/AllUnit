<?php

class TBkContentListControl extends TControl {
	
	const ITEMS_PER_PAGE = 50;

	function OnCreateEvent($Sender) {
		$this->SetEvent('list', array($this, 'OnListEvent'));
		$this->location = new TLocation($this, [TAu::MANAGE,"content","*"]);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}

	function OnEnableEvent($Sender) {
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/content-list.css");
		$vars = $this->location->getVars();
		$slug = $vars[0];

		$factory = TConfigManager::GetModel('IViewModelFactory', null, $filename);
		$factory->includeViewModels($filename);

		$this->viewModel = $factory->createBySlug($slug);
		$Sender->Data['permalink'] = TAu::getSiteUrl()."/".TAu::MANAGE."/content/".$slug;
		//$this->list($viewModel);
	}
	
	function OnGetEvent($Sender, $Input) {
		if($this->IsEnabled()) {
			$this->list($Input);
		}
	}
	
	public function OnListEvent($Sender, $Input) {

		$viewModel = $this->viewModel;

		$singleClass = $viewModel->getSingleModelName();
		$single = new $singleClass();
		$fields = $single->getFields();
		foreach($fields as $field) {
			$temp = $field;
			if(!isset($field['title'])) {
				$temp['title'] = $field['name'];
			}
			$Sender->Data['fields'][] = $temp;
		}
		$list = $viewModel->getListModel();
		$items = $list->getList($Input);
		foreach($items as $item) {
			$temp = $item->getDataAsArray();
			$temp['id'] = $item->getId();
			$Sender->Data['list'][] = $temp;
		}
		$Sender->Data['itemsperpage'] = self::ITEMS_PER_PAGE;
		$count = (int)$Input['itemsperpage'];
		if($count>0) {
			$Sender->Data['itemsperpage'] = $count;
		}
		
		$Sender->Data['paginationLinks'] = $this->createPagination($Sender->Data['itemsperpage'], $list->getTotal());
		$Sender->Data['currentPage'] = (int)$Input['page']+1;
		$Sender->Data['sortLinks'] = $this->createSortLinks(array_column($fields, 'name'));
	}
	
	function createPagination($itemsperpage, $total) {
		$count = round($total/$itemsperpage)+1;
		$res = array();
		for($i=0;$i<$count;$i++) {
			$res[] = [
				'title' => $i+1,
				'link' => TXml::cdata(self::addLinkVars(['page'=>$i]))
			];
		}
		return $res;
	}
	
	function createSortLinks($fieldNames) {
		$res = array();
		foreach($fieldNames as $field) {
			$res[] = [
				'name' => $field,
				'asc' => TXml::cdata(self::addLinkVars([
					'sort'=>$field,
					'sortdir'=>''
					])),
				'desc' => TXml::cdata(self::addLinkVars([
					'sort'=>$field,
					'sortdir'=>'DESC'
					]))
			];
		}
		return $res;
	}
	
	function addLinkVars($varsToAdd) {

		$base = $_SERVER['REDIRECT_URL'];
		$vars = $_GET;
		
		$vars = array_merge($vars, $varsToAdd);
		unset($vars['event']);
		$varStrings = array();
		foreach($vars as $key=>$value) {
			if(!empty($value)) {
				if(is_array($value)) {
					foreach($value as $key2=>$item) {
						if(!empty($item)) {
							$varStrings[] = $key."[".$key2."]=".$item;
						}
					}
				} else {
					$varStrings[] = $key.'='.$value;
				}
			}
		}
		//var_dump($varStrings);
		return $base."?".implode("&",$varStrings);
	}

}
