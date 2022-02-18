<?php namespace App\Smarty;

use CodeIgniter\Config\BaseConfig;

class Config extends BaseConfig
{
	/**
	 *---------------------------------------------------------------
	 * TEMPLATE DIRECTORY
	 *---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "template directory" folder.
	 *
	 * @var string
	 */
	public $templateDir = APPPATH . 'Views';
	
	/**
	 *---------------------------------------------------------------
	 * COMPILE DIRECTORY
	 *---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "compile directory" folder.
	 *
	 * @var string
	 */
	//public $compileDir = APPPATH . 'Views/templates_c';		
	public $compileDir = '/tmp';		
	
	/**
	 *---------------------------------------------------------------
	 * CONFIG DIRECTORY
	 *---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "config directory" folder.
	 *
	 * @var string
	 */
	public $configDir = APPPATH . 'Views/configs';
	
	/**
	 *---------------------------------------------------------------
	 * CACHE DIRECTORY
	 *---------------------------------------------------------------
	 *
	 * This variable must contain the name of your "cache directory" folder.
	 *
	 * @var string
	 */
	//public $cacheDir = APPPATH . 'Views/cache';
	public $cacheDir = '/tmp';
}
