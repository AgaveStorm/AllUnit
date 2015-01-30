<?php

interface IField {
	/**
	 * @return name of the field, aka sql column name
	 */
	public function getName();
	
	/**
	 * @return field type (id, bool, text and so on)
	 */
	public function getType();
	
	/**
	 * @return human readable field title
	 */
	public function getTitle();
	
	/**
	 * hook for modifing field data before set. Implement this function if you need
	 * to make some adjastments before saving data
	 * @param $value initial not modified value as set by application user
	 * @param $single TSingle child object
	 * @return modified value
	 */
	public function beforeSet($value, $single);
	
	/**
	 * hook for modifing field data before get if for reading. Used in TSingle::get(), TSingle::getDataAsArray()
	 * @param $value initial not modified value as stored in database
	 * @param $single TSingle child object
	 * @return modified value
	 */
	public function beforeGet($value, $single);
	
	/**
	 * hook for modifing field data before get it for editing. Used in TSingle::getE(), TSingle::getDataAsArrayE()
	 * @param $value initial not modified value as stored in database
	 * @param $single TSingle child object
	 * @return modified value
	 */
	public function beforeGetE($value, $single);
}
