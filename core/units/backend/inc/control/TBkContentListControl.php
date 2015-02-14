<?php

class TBkContentListControl extends TControl {
	
	const ITEMS_PER_PAGE = 50;

	function OnCreateEvent($Sender) {
		$this->SetEvent('list', array($this, 'OnListEvent'));
		$this->location = new TLocation($this, [TAu::MANAGE,"content",new TVmSlugLocVar()]);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}

	function OnEnableEvent($Sender) {
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/content-list.css");
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/filter.css");
		TJs::add(TBackendContainer::getUnitUrlStatic()."/js/filter.js", null, ['jquery']);
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
		$fields = $single->getFieldObjects();
		foreach($fields as $field) {
			$temp = $field->asArray();
		
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
		
		$Sender->Data['paginationLinks'] = $this->createPagination($Sender->Data['itemsperpage'], $list->getTotal($Input));
		$Sender->Data['currentPage'] = (int)$Input['page']+1;
		$fieldNames = array_column($fields, 'name');
		$Sender->Data['sortLinks'] = $this->createSortLinks($fieldNames);
		$Sender->createFilterVals($Sender, $Input, $fieldNames);
		$Sender->createRelatedLists($Sender);
		
	}
	
	function getRelatedLists() {
		$singleClass = $this->viewModel->getSingleModelName();
		$single = new $singleClass();
		$list = $single->getFieldObjects();
		$res = [];
		foreach($list as $item) {
			if(!empty($item->get('list')) /*&& $item['type'] == 'multiid'*/) {
				$res[] = $item->get('list');
			}
		}
		return $res;
	}
	
	function createRelatedLists($Sender) {
		foreach($this->getRelatedLists() as $listSlug) {

			$factory = new TViewModelFactory();
			$viewModel = $factory->createBySlug($listSlug);

			if(empty($viewModel)) {
				continue;
			}
			$list = $viewModel->getListModel();
			$items = $list->getAll();
			foreach($items as $item) {
				$postData = array();
				if(is_object($item)) {
					$postData['id'] = $item->getId();
					$postData['title'] = $item->getTitle();
				}
				if(is_array($item)) {
					$postData['id'] = $item['id'];
					$postData['title'] = $item['title'];
				}
				$Sender->Data[$listSlug][] = $postData;
			}
		}
	}
	
	function createFilterVals($Sender, $Input, $fieldNames) {
		if(!empty($Input['FilterClick'])) {
			$filter = [];
			foreach($fieldNames as $field) {
				if(empty($Input[$field])) {
					continue;
				}
				if(is_array($Input[$field])) {
//					if(empty($Input[$field]['from']) &&
//						empty($Input[$field]['to'])) {
//						continue;
//						}
				}
				
				$filter[] = [
					'name' => $field,
					'value' => $Input[$field]
				];
			}
			$Sender->Data['filtervals'] = $filter;
			$forJson = array();
			foreach($filter as $item) {
				$forJson[$item['name']] = $item['value'];
			}
			$Sender->Data['jsonFilter'] = json_encode($forJson);
			
		}
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
