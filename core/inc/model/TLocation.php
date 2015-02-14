<?php

require_once 'TLocVar.php';
require_once 'TPage.php';

class TLocation {
	
	const INCLUDE_CHILDREN = true;
	
	private $control;
	private $slug;
	private $vars;
	
	function __construct($control, $slug='', $includeChildren = false, $titleFunc = array('TLocation','defaultTitleFunc')) {
		$this->titleFunc = $titleFunc;
		$this->control = $control;
		$this->slug = $slug;
		$this->vars = array();
		$this->includeChildren = $includeChildren;
		TLocations::add($this);
	}
	
	function getSlug() {
		return $this->slug;
	}
	
	function getVars() {
		return $this->vars;
	}
	
	function getControl() {
		return $this->control;
	}
	
	function getCurrentPath() {
		return $_SERVER['REDIRECT_URL'];
	}
	
	/**
	 * calculate location title using location vars
	 */
	function getTitle($slug) {
		$callback = $this->getTitleFunc();
//		$clbclass = reset($callback);
//		if(is_object($clbclass)) {
//			$clbclass = get_class($clbclass);
//		}
//		echo "\n".get_class($this->control)."-".$clbclass."::".$callback[1]."=".$slug."\n";
		return $callback($slug, $this->parseVars($slug));
	}
	
	function getTitleFunc() {
		return $this->titleFunc;
	}
	
	function defaultTitleFunc($slug, $vars) {
		return $slug;
	}
	
	function getLocVarObjects() {
		$re = [];
		if(is_array($this->getSlug())) {
			foreach($this->getSlug() as $item) {
				if($item instanceof ILocVar) {
					$re[] = $item;
				}
			}
		}
		return $re;
	}
	
	/**
	 * return all possible pages for this location
	 */
	function getPages() {
		if(!is_array($this->getSlug())) {
			return [ new TPage($this->getSlug(),$this->getSlug())];
		}
		$re =  $this->createPages($this->getSlug());
		return $re;
	}
	
	function createPages($slug) {
		if(empty($slug)) {
			return [];
		}
		$slugItem = reset($slug);
		unset($slug[0]);
		$slug = array_values($slug);
		$tree = $this->appendTree([], $slugItem, $slug);
		return $this->appendToPages([], $tree);
	}
	
	function appendToPages($cur, $tree, $res = []) {
		foreach($tree as $key=>$branch) {
			if(!is_array($branch)) {
				$cur[] = $branch;
				
				
				if(!$this->hasBranches($tree)
					&& $key == count($tree)-1 // last item
//					&& count($tree) == 1
					) {
					$title = '';
					$locvar = null;
//					if(is_string($branch)) {
//						$title = $branch;
//					}
//					if($branch instanceof ILocVarValue) {
//						$title = $branch->getTitle();
//						$locvar = $branch;
//					}
					$page = new TPage($cur, $title, $locvar);
					$res[] = $page;
				}
			}
			if(is_array($branch)) {
				$res = $this->appendToPages($cur, $branch, $res);
			}
		}
		return $res;
	}
	
	function hasBranches($tree) {
		foreach($tree as $leaf) {
			if(is_array($leaf)) {
				return true;
			}
		}
		return false;
	}
	
	function appendTree($cur, $slugItem, $slug, $prevs = []) {
		if(empty($slugItem)) {
			return $cur;
		}
		$nextSlugItem = reset($slug);
		unset($slug[0]);
		$slug = array_values($slug);
		
		if(is_string($slugItem)) {
			$cur[] = $slugItem;
			return $this->appendTree($cur,$nextSlugItem, $slug, $prevs);
		}
		
		if($slugItem instanceof ILocVar) {
			foreach($slugItem->getAllPossible($prevs) as $id) {
				$temp = [];
				$temp[] = $id;
				$nextPrevs = $prevs;
				$nextPrevs[] = $id;
				$cur[] = $this->appendTree($temp,$nextSlugItem, $slug, $nextPrevs);
			}
			return $this->appendTree($cur,null, []);
		}
	}
	
	
	function current() {
		$basePath = str_replace("/index.php","",$_SERVER['PHP_SELF']);
		
		$thisPath = @$_SERVER['REDIRECT_URL'];
		$strippedPath = substr($thisPath,strlen($basePath."/"));
		if(!is_array($this->slug)) {
			$exploded = explode("/",$strippedPath);
			if($this->slug == $strippedPath || (
				$this->includeChildren
				&& reset($exploded) == $this->slug
				)) {
				return true;
			}
		}
		if(is_array($this->slug)) {
			$exploded = explode("/",$strippedPath);
			
			if(count($exploded) < count($this->slug)) {
				return false;
			}
			$ok = true;
//			$this->vars = array();
			foreach($exploded as $key=>$value) {
				$ok = $ok && (@$this->slug[$key] == $value 
					|| @($this->slug[$key] instanceof ILocVar )
					|| @($this->slug[$key] == '*')
					|| ( 
						$key > count($this->slug)-1
						&& $this->includeChildren
						));
			}
			$this->vars = $this->parseVars($strippedPath);
			return $ok;
		}
		return false;
	}
	
	/**
	 * @param string $path location string like something/something/something
	 */
	function parseVars($path) {
		$exploded = explode("/",$path);
		$vars = [];
		foreach($exploded as $key=>$value) {
			if( (@($this->slug[$key] instanceof ILocVar) 
				|| @($this->slug[$key] == '*')
				)&& !empty($value)) {
				$vars[] = $value;
				}
		}
		return $vars;
	}
}
