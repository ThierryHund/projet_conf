<?php
require_once 'Smarty.class.php';
class SmartyIUT extends Smarty {
	public function __construct() {
		parent::__construct ();
		
		$this->template_dir = 'templates/';
		$this->compile_dir = 'smarty/templates_c/';
		$this->config_dir = 'smarty/configs/';
		$this->cache_dir = 'smarty/cache/';
	}
}
?>
		

