<?php

require_once 'allunit/core/inc/fields/TAuField.php';
require_once 'allunit/core/inc/fields/TBoolField.php';
require_once 'allunit/core/inc/fields/TMultiidField.php';
require_once 'allunit/core/inc/fields/TDateField.php';
require_once 'allunit/core/inc/fields/TDateTimeField.php';
require_once 'allunit/core/inc/fields/TTimeField.php';
require_once 'allunit/core/inc/fields/TDefaultField.php';

class EUniqueField extends Exception {}
class EFieldObjectNotFound extends Exception {}

abstract class TSingle {
	
	protected $bean;
	
	function __construct($bean = null, $createBean = false) {
		$this->bean = $bean;
		if($this->bean == null && $createBean) {
			$this->bean = R::dispense($this->getBeanType());
		}
	}
	
	/**
	 * @return array of fields
	 * example
	 * [
	 *	    ['name'=>'login','title'=>'Login'],
	 *	    ['name'=>'phone','title'=>'Phone Number'],
	 *	    new TBoolField(['name'=>'boolfield']),
	 *	    ['name'=>'passwd','title'=>'Password','type'=>'password']
	 * ]
	 * so we can describe database item in declarative way
	 * @important you do not need to create/update tables yourself. Database structure will be managed by AllUnit automatically 
	 */
	abstract public function getFields();
	
	/**
	 * @return array of field obejcts see IField
	 */
	public function getFieldObjects() {
		$items = $this->getFields();
		foreach($items as $key=>$value) {
			if(is_array($value)) {
				$items[$key] = new TDefaultField($value);
			}
		}
		return $items;
	}
	public function getFieldObjectByName($name) {
		foreach($this->getFieldObjects() as $item) {
			if($item->getName() == $name) {
				return $item;
			}
		}
		throw new EFieldObjectNotFound();
	}
	
	/**
	 * @return bean type (in terms of RedBean ORM), aka table name 
	 */
	public function getBeanType(){
		return strtolower(get_class($this));
	}


	public function getActions() {
		return [];
	}
	
	public function getUniqueFields() {
		return [];
	}
	public function getReadonlyFields() {
		return [];
	}
	public function getHiddenColumns() {
		return [];
	}
	public function isReadonlyField($name) {
		return in_array($name, $this->getReadonlyFields());
	}
	
	public function getOptionalFields() {
		return [];
	}
	public function isOptionalField($name) {
		return in_array($name, $this->getOptionalFields());
	}
	
	public function getCalcFields() {
		return [];
	}	
	public function isCalc($name) {
		return in_array($name, $this->getCalcFields());
	}
	public function isSelectable() {
		return false;
	}
	
	function isXmlField($name) {
		foreach($this->getFieldObjects() as $field) {
			if($field->getType() == 'multiid') {
				return true;
			}
		}
		return false;
	}
	
	public function getId() {
		return $this->bean->id;
	}
	
	public function getTitleField() {
		$fields = $this->getFieldObjects();
		$names = [];
		foreach($fields as $field) {
			$names[] = $field->getName();
		}
		if(in_array('title', $names)) {
			return 'title';
		}
		$field = reset($names);
		if(!empty($field)) {
			return $field;
		}
		return 'id';
	}
	
	public function getTitle() {
		$field = $this->getTitleField();
		if($field != 'id') {
			return $this->get($field);
		}
		return $this->getId();
	}
	
	function get($field) {
		$object = $this->getFieldObjectByName($field);
		return $object->beforeGet($this->bean->$field, $this);
	}
	
	function getE($field) {
		$object = $this->getFieldObjectByName($field);
		return $object->beforeGetE($this->bean->$field, $this);
	}
	
	function getRaw($field) {
		return $this->bean->$field;
	}
	
	function getFieldType($fieldName) {
		foreach($this->getFieldObjects() as $field) {
			if($field->getName() == $fieldName) {
				return $field->getType();
			}
		}
	}
	
	public function getDataAsArray() {
		$res = [];
		foreach($this->getFieldObjects() as $field) {
			$name = $field->getName();
			if($name == null) {
				continue;
			}
			$res[$name] = TXml::cdata($this->get($name));
		}
		return $res;
	}
	/**
	 * for editing - ids instead of values in lists
	 */
	public function getDataAsArrayE() {
		$res = [];
		foreach($this->getFieldObjects() as $field) {
			$name = $field->getName(); //['name'];
			if($name == null) {
				continue;
			}
			$res[$name] = $this->getE($name);
		}
		return $res;
	}
	
	public function set($field, $value) {
		$object = $this->getFieldObjectByName($field);
		$this->bean->$field = $object->beforeSet($value);
	}
	
	public function setData($input) {
//		var_dump($input); exit;
		//$dbacl = new TDbAcl();
		
		foreach($this->getFieldObjects() as $field) {
			//$this->set($field['name'], $input[$field['name']]);
			$name = $field->getName();
//			if(!$dbacl->currentUserCan($this->getBeanType(), $name, 'w')) {
//				continue;
//			}
			$type = $field->getType();
			$empty = false;
			if(is_array($input[$name])) {
				$empty = empty($input[$name]);
			} else {
				$empty = empty(trim($input[$name]));
			}
			if($empty && !$this->isOptionalField($name) && !$this->isReadonlyField($name) && $type != 'bool' && $type !='passwd' && $type !='separator' && $name != null) {
				throw new Exception('Заполнены не все поля (поле '.$name.')');
			}
			if($name == null) {
				continue;
			}
			// do not update password if new password is empty
			if($type == 'passwd' || $this->isReadonlyField($name)) {
				if(empty($input[$name])) {
					continue;
				}
			}
			
			$this->bean->$name = $field->beforeSet($input[$name], $this);
		}
//                var_dump($this->bean);
	}
	
	/**
	 * @param $name name of the field
	 * @param $type sql type of the field, see RedBean docs for list of possible types
	 * 
	 * By default RedBean try to guess culumn type by content, however sometimes we need to force table column to use type we need
	 * @example class TDateField extends TAuField {
		function beforeSet($value, $single) {
			$single->castSqlType($this->getName(),'date');
			return $value;
		} 
	 */
	function castSqlType($name, $type) {
		$this->bean->setMeta('cast.'.$name,$type);
	}
	
	/**
	 * @return id of the record
	 */
	function save() {
		try {
			$single = $this->getUniqueFields();
			if(!empty($single) && is_array($single)) {
				foreach($single as $key=>$value) {
				$sql = "
					CREATE UNIQUE INDEX
						".$this->getBeanType()."_".$value."_unique
					ON
						".$this->getBeanType()."
						(".$value."(100))
					";
				R::exec($sql);
				}
			}
		}catch(RedBean_Exception_SQL $e) {
//			echo $e;
		}
		try {
			return R::store($this->bean);
		} catch(RedBean_Exception_SQL $e) {
			throw new EUniqueField($e->getMessage());
		}
	}
	function remove() {
		return R::trash($this->bean);
	}
}
