<?php

class EUniqueField extends Exception {}

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
	 *	    ['name'=>'passwd','title'=>'Password','type'=>'password']
	 * ]
	 * so we can describe database item in declarative way
	 * @important you do not need to create/update tables yourself. Database structure will be managed by AllUnit automatically 
	 */
	abstract public function getFields();
	
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
		foreach($this->getFields() as $field) {
			if($field['type'] == 'multiid') {
				return true;
			}
		}
		return false;
	}
	
	public function getId() {
		return $this->bean->id;
	}
	public function getTitle() {
		return $this->bean->title;
	}
	
	function get($field) {
		//var_dump($this->getFieldType($field));
		if($this->getFieldType($field) == 'date') {
			return date('d.m.Y', strtotime($this->bean->$field));
		}
		if($this->getFieldType($field) == 'editor') {
			
			return htmlspecialchars_decode($this->bean->$field);
		}
		return $this->bean->$field;
	}
	
	function getE($field) {
		if($this->getFieldType($field) == 'date') {
			return date('d.m.Y', strtotime($this->bean->$field));
		}
		if($this->getFieldType($field) == 'id') {
			$name = $field."_id";
			$id = $this->bean->$name;
			if(!empty($id)) {
				return $id;
			}
		}
		return htmlspecialchars_decode($this->bean->$field);
	}
	
	function getFieldType($fieldName) {
		foreach($this->getFields() as $field) {
			if($field['name'] == $fieldName) {
				return $field['type'];
			}
		}
	}
	
	public function getDataAsArray() {
		$res = [];
		foreach($this->getFields() as $field) {
			$name = $field['name'];
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
		foreach($this->getFields() as $field) {
			$name = $field['name'];
			if($name == null) {
				continue;
			}
			$res[$name] = $this->getE($name);
		}
		return $res;
	}
	
	public function set($field, $value) {
		$this->bean->$field = $value;
	}
	
	public function setData($input) {
		//$dbacl = new TDbAcl();
		
		foreach($this->getFields() as $field) {
			//$this->set($field['name'], $input[$field['name']]);
			$name = $field['name'];
//			if(!$dbacl->currentUserCan($this->getBeanType(), $name, 'w')) {
//				continue;
//			}
			$type = $field['type'];
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
			if($field['type'] == 'passwd' || $this->isReadonlyField($name)) {
				if(empty($input[$name])) {
					continue;
				}
			}
			if($field['type'] == 'passwd') {
				$input[$name] = sha1($input[$name]); // hash passwords
			}
			if($field['type'] == 'multiid') {
				//var_dump($input); exit;
				$input[$name] = TXml::MakeTree($input[$name],'ids');
			}
			if($field['type'] == 'date') {
				$input[$name] = date('Y-m-d', strtotime($input[$name]));
				$this->bean->setMeta('cast.'.$name,'date');
			}
			$this->bean->$name = $input[$name];
		}
//                var_dump($this->bean);
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
