<?php


abstract class VBaseModel {
    
    abstract public function getSlug();
    abstract public function getListModel();
//    abstract public function getNewLabel();

    public function getTitle() {
	    return get_class($this);
    }

    public function getButtonSlug() {
	    return get_class($this);
    }
    
    public function getSingleModelName() {
	   $list = $this->getListModel();
	   return $list->getSingleModelName();
    }
            
    function getAddNewLink() {
        return TSite::getSiteUrl()."/".$this->getSlug()."/add";
    }
    
    function getBean() {
        $model = $this->getSingleModelName();
        return $model::getBeanType();
    }
    
    function getLabelSuffix() {
	    return;
    }
}
