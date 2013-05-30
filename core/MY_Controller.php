<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Base Controller
 *
 * The file is part of "CodeIgniter Base Controllers" package that
 * aims to simplify the development of controllers by introducing
 * and autoloading a few base controller classes to the application.
 *
 * Make sure that you already read the installation instruction at
 * its repository README file: https://github.com/sepehr/ci-base-controllers
 *
 * In order for this package to perform correctly:
 *
 * 1. These files should exist:
 * - application/core/MY_Controller.php
 * - application/core/Public_Controller.php (a base controller - optional)
 * - application/core/Admin_Controller.php  (a base controller - optional)
 * - application/hooks/CI_Autoloader.php
 *
 * 2. Hooks must be enabled in application config.php file.
 *
 * 3. A pre_system hook must already be registered in application hooks.php config file:
 * $hook['pre_system'] = array(
 *     'class'    => 'CI_Autoloader',
 *	   'function' => 'register',
 *	   'filename' => 'CI_Autoloader.php',
 *	   'filepath' => 'hooks',
 *	   'params'   => array(APPPATH . 'base/')
 * );
 *
 * @package		CodeIgniter
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @copyright	Copyright (c) 2012 Sepehr Lajevardi.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/sepehr/ci-base-controllers
 * @version 	Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Application Base Controller
 *
 * The common shared code for all application controllers should be placed here.
 * NOTE: If you're using Modular Extensions and you want the HMVC feature in place,
 * you need to alter this to extend MX_Controller instead of CI_Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 * @see			http://highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
 */
abstract class Base_Controller extends CI_Controller {

	/**
	 * Application base controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */