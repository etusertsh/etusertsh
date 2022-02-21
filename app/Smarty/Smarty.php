<?php namespace App\Smarty;

require_once( 'smarty3/Smarty.class.php' );

class Smarty extends \Smarty
{
	protected $config;
	
	public function __construct() 
	{
		parent::__construct();
		
		if ($this->config !== $this->config instanceof \App\Smarty\Config)
		{
			$this->config = new \App\Smarty\Config();
		}
				
		$this->template_dir = $this->config->templateDir;		
		$this->compile_dir = $this->config->compileDir;		
		$this->config_dir = $this->config->configDir;
		$this->cache_dir = $this->config->cacheDir;
		//$this->left_delimiter = '{';
		//$this->right_delimiter = '}';
		$this->loadFilter('output', 'trimwhitespace');
		
		$this->assign( 'APPPATH', APPPATH );
		$this->assign( 'SYSTEMPATH', SYSTEMPATH );

		
		$this->force_compile = true;
		$this->caching = \Smarty::CACHING_LIFETIME_CURRENT;
		$this->cache_lifetime = 520;
		
	}
	
	public function view(string $view, array $options = null) 
	{
		$result = $this->fetch($view);
			
		return $result;
	}
	
	public function setData(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			$this->assign($key, $value);
		}
		
		return $this;
	}
}