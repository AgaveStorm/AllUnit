<?php

if(!class_exists('R')) {
	TConfigManager::GetModel("IRbConfig", $this)->InitRb();	
}

require_once "TSingle.php";

abstract class TList {
	
	const ITEMS_PER_PAGE = 50;
	
	abstract public function getSingleModelName();
	
	public function getBeanType() {
		$singleModel = $this->getSingleModelName();
		$single = new $singleModel();
		return $single->getBeanType();
	}
	
	public function getViewName() {
		return $this->getBeanType().'_view';
	}
	
	public function getFields() {
		$singleModel = $this->getSingleModelName();
		$single = new $singleModel();
		return $single->getFields();
	}
	
	public function getAll() {	
		$this->createView();
		$beans = R::find($this->getViewName());		
		$singleModel = $this->getSingleModelName();		
		$res = array();
		foreach($beans as $bean) {
			$res[] = new $singleModel($bean);
		}
		return $res;
	}
	
	public function getTotal() {
		return R::count($this->getViewName());
	}
	
	public function getList($Input) {
		$fields = $this->getFields();
		
		$where = $this->createWhere($fields, $Input);
		$orderby = $this->createOrderBy($fields, $Input);
		$limit = $this->createLimit($Input);
	
		$this->createView();

		$beans = R::find($this->getViewName(),$where.' ORDER BY '.$orderby.' LIMIT '.$limit);
		
		$singleModel = $this->getSingleModelName();
		
		$res = array();
		foreach($beans as $bean) {
			$res[] = new $singleModel($bean);
		}
		return $res;
	}
	
	public function getRandom($limit, $Input) {
		$fields = $this->getFields();
//		
		$where = $this->createWhere($fields, $Input);
//		var_dump($where);
//		$orderby = $this->createOrderBy($fields, $Input);
//		$limit = $this->createLimit($Input);
	
		$this->createView();

		$beans = R::find($this->getViewName(),$where.' ORDER BY RAND() LIMIT '.$limit);
		
		$singleModel = $this->getSingleModelName();
		
		$res = array();
		foreach($beans as $bean) {
			$res[] = new $singleModel($bean);
		}
		return $res;
	}
	
	function getOne($id) {
		$class = $this->getSingleModelName();
		$bean = R::load($this->getBeanType(), $id);
		return new $class($bean);
	}
	
	function readOne($id) {
		$class = $this->getSingleModelName();
		$bean = R::load($this->getViewName(), $id);
		return new $class($bean);
	}
	
	function createWhere($fields, $Input, $table = null) {
		$filter = array();
		foreach ($fields as $field) {
		    if (!empty($Input[$field['name']])) {
			if (is_array($field['type'])) {
			    $filter[] = $field['name'] . " = '" . $Input[$field['name']] . "'";
			    continue;
			}
			switch ($field['type']) {
			    case 'date':
			    case 'cardno':
				$from = $Input[$field['name']]['from'];
				$to = $Input[$field['name']]['to'];
				if (!empty($from) && !empty($to)) {
				    if ($field['type'] == 'date') {
					$from = date('Y-m-d', strtotime($from));
					$to = date('Y-m-d', strtotime($to));
				    }
				    $filter[] = $field['name']." BETWEEN '".$from."' AND '".$to."' ";
				} elseif (!empty($from)) {
				    $filter[] = $field['name'] . "='".$from."'";
				}
				break;
			    case 'multiid':
				$ids = $Input[$field['name']];
				$comp = [];
				foreach ($ids as $id) {
				    $comp[] = '//item[.="'.$id .'"]';
				}
				$filter[] = "ExtractValue(".$field['name'].",'".implode(' | ', $comp)."') <> ''";
				break;
			    case 'id':
				    $prefix = '';
				    if (!empty($table)) {
					$prefix = $table.".";
				    }
				$ids = $Input[$field['name']];
				if (is_array($ids)) {
				    $filter[] = $prefix.$field['name']."_id IN ('".implode("','", $ids)."')";
				} else {
					$filter[] = $prefix.$field['name']."_id = '" .$Input[$field['name']]."'";
				}
				break;
			    default:
				$filter[] = $field['name']." LIKE '%".$Input[$field['name']]."%'";
				break;
			}
		    }
		}
		return implode(' AND ', $filter);
	}
	
	function createOrderBy( $fields, $Input) {
		$fieldNames = array();
		foreach($fields as $field) {
			$fieldNames[] = $field['name'];
		}
		$orderby = 'id';
		if(!empty($Input['sort'])) {
			if(in_array($Input['sort'], $fieldNames)) {
				$orderby = $Input['sort'];
			}
		}
		if(!empty($Input['sortdir'])) {
			$orderby .= ' DESC';
		}
		return $orderby;
	}
	
	function createLimit($Input) {
		$itemsperpage = self::ITEMS_PER_PAGE;
		$count = (int)$Input['itemsperpage'];
		if($count > 0) {
			$itemsperpage = $count;
		}
		$page = (int)$Input['page'];

		$offset = $page*$itemsperpage;
		return $offset.','.$itemsperpage;
	}
	
	function createView() {
		$joins = $this->createJoins();		
		$fieldsToSelect = $this->createFieldsToSelect();
		$sqlFields = implode(',',$fieldsToSelect);
		
		$sql = "
			CREATE OR REPLACE VIEW ".$this->getViewName()."
			AS
			SELECT  `".$this->getBeanType()."`.id, ".$sqlFields."
			FROM `".$this->getBeanType()."`
		".$joins;
		//$sql = str_replace("\n",'',str_replace("\t",' ',$sql));
		//var_dump($sql);
		R::exec($sql);
	}
	
	function createJoins() {
		$joins = '';
		foreach($this->getFields() as $field) {
			if($field['name'] == null) {
				continue;
			}
			$factoryModel = TConfigManager::GetModel('IViewModelFactory');
			$factory = new $factoryModel();
			if(!empty($field['list']) && $field['type'] == 'id') {
				$viewModel = $factory->createBySlug($field['list']);
                                if(empty($viewModel)) {
                                    $viewModel = $factory->createByBean($field['list']);
                                }
                                $list = $viewModel->getListModel();
				$joins .= "
					LEFT JOIN `".$list->getBeanType()."`
						AS ".$list->getBeanType().$field['name']."	
					ON (
						`".$list->getBeanType().$field['name']."`.id = `".$this->getBeanType()."`.".$field['name']."
					)";
			}
		}
		return $joins;
	}
	
	public function titleToSelect($fieldName) {
		return "`".$this->getBeanType().$fieldName."`.`title` AS `".$fieldName."`";
	}
	
	function createFieldsToSelect() {
		$fieldsToSelect = array();
		foreach($this->getFields() as $field) {
			if($field['name']==null) {
				continue;
			}
			if($field['calc'] == true) {
				continue;
			}
			$temp = "`".$this->getBeanType()."`.`".$field['name']."`";
			$factoryModel = TConfigManager::GetModel('IViewModelFactory');
			$factory = new $factoryModel();
			if(!empty($field['list']) && $field['type'] == 'id') {
				$viewModel = $factory->createBySlug($field['list']);
                                if(empty($viewModel)) {
                                    $viewModel = $factory->createByBean($field['list']);
                                }
				$list = $viewModel->getListModel();
				$temp = $list->titleToSelect($field['name']);
				$temp .= ",`".$list->getBeanType().$field['name']."`.`id` AS `".$field['name']."_id`";
			}
			$fieldsToSelect[] = $temp;
		}
		return $fieldsToSelect;
	}
	
	
	public function create($input) {
		$class = $this->getSingleModelName();
		$group = new $class(null, true);
		$group->setData($input);
		return $group;
	}
	
	public function removeAll() {
		R::wipe($this->getBeanType());
	}
}
