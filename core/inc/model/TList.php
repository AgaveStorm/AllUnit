<?php

require_once "TSingle.php";

abstract class TList {
	
	const ITEMS_PER_PAGE = 50;
	
	public function __construct() {
		if(!class_exists('R')) {
			TConfigManager::GetModel("IRbConfig", $this)->InitRb();	
		}
	}


	abstract public function getSingleModelName();
	
	public function getBeanType() {
		$singleModel = $this->getSingleModelName();
		$single = new $singleModel();
		return $single->getBeanType();
	}
	
	public function getViewName() {
		return $this->getBeanType().'_view';
	}
	
	public function getFieldObjects() {
		$singleModel = $this->getSingleModelName();
		$single = new $singleModel();
		return $single->getFieldObjects();
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
		$fields = $this->getFieldObjects();
		
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
		$fields = $this->getFieldObjects();
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
		    if (!empty($Input[$field->getName()])) {
			if (is_array($field->getType())) {
			    $filter[] = $field->getName() . " = '" . $Input[$field->getName()] . "'";
			    continue;
			}
			switch ($field->getType()) {
			    case 'date':
			    case 'cardno':
				$from = $Input[$field->getName()]['from'];
				$to = $Input[$field->getName()]['to'];
				if (!empty($from) && !empty($to)) {
				    if ($field['type'] == 'date') {
					$from = date('Y-m-d', strtotime($from));
					$to = date('Y-m-d', strtotime($to));
				    }
				    $filter[] = $field->getName()." BETWEEN '".$from."' AND '".$to."' ";
				} elseif (!empty($from)) {
				    $filter[] = $field->getName() . "='".$from."'";
				}
				break;
			    case 'multiid':
				$ids = $Input[$field->getName()];
				$comp = [];
				foreach ($ids as $id) {
				    $comp[] = '//item[.="'.$id .'"]';
				}
				$filter[] = "ExtractValue(".$field->getName().",'".implode(' | ', $comp)."') <> ''";
				break;
			    case 'id':
				    $prefix = '';
				    if (!empty($table)) {
					$prefix = $table.".";
				    }
				$ids = $Input[$field->getName()];
				if (is_array($ids)) {
				    $filter[] = $prefix.$field->getName()."_id IN ('".implode("','", $ids)."')";
				} else {
					$filter[] = $prefix.$field->getName()."_id = '" .$Input[$field->getName()]."'";
				}
				break;
			    case 'number':
				    $filter[] = $field->getName()." = '".$Input[$field->getName()]."'";
				    break;
			    default:
				$filter[] = $field->getName()." LIKE '%".$Input[$field->getName()]."%'";
				break;
			}
		    }
		}
		return implode(' AND ', $filter);
	}
	
	function createOrderBy( $fields, $Input) {
		$fieldNames = array();
		foreach($fields as $field) {
			$fieldNames[] = $field->getName();
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
//		$sql = str_replace("\n",'',str_replace("\t",' ',$sql));
//		var_dump($sql);
		R::exec($sql);
	}
	
	function createJoins() {
		$joins = '';
		foreach($this->getFieldObjects() as $field) {
			if($field->getName() == null) {
				continue;
			}
			$factoryModel = TConfigManager::GetModel('IViewModelFactory');
			$factory = new $factoryModel();
			if(!empty($field->get('list')) && $field->getType() == 'id') {
				$viewModel = $factory->createBySlug($field->get('list'));
                                if(empty($viewModel)) {
                                    $viewModel = $factory->createByBean($field->get('list'));
                                }
                                $list = $viewModel->getListModel();
				$joins .= "
					LEFT JOIN `".$list->getBeanType()."`
						AS ".$list->getBeanType().$field->getName()."	
					ON (
						`".$list->getBeanType().$field->getName()."`.id = `".$this->getBeanType()."`.".$field->getName()."
					)";
			}
		}
		return $joins;
	}
	
	public function titleToSelect($fieldName) {
		$class = $this->getSingleModelName();
		$single = new $class();
		return "`".$this->getBeanType().$fieldName."`.`".$single->getTitleField()."` AS `".$fieldName."`";
	}
	
	function createFieldsToSelect() {
		$fieldsToSelect = array();
		foreach($this->getFieldObjects() as $field) {
			if($field->getName()==null) {
				continue;
			}
			if($field->get('calc') == true) {
				continue;
			}
			$temp = "`".$this->getBeanType()."`.`".$field->getName()."`";
			$factoryModel = TConfigManager::GetModel('IViewModelFactory');
			$factory = new $factoryModel();
			if(!empty($field->get('list')) && $field->getType() == 'id') {
//				var_dump($field->get('list'));
				$viewModel = $factory->createBySlug($field->get('list'));
                                if(empty($viewModel)) {
                                    $viewModel = $factory->createByBean($field->get('list'));
                                }
				$list = $viewModel->getListModel();
				$temp = $list->titleToSelect($field->getName());
				$temp .= ",`".$list->getBeanType().$field->getName()."`.`id` AS `".$field->getName()."_id`";
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
