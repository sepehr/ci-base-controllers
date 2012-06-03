<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application Base Controller for public pages.
 *
 * The common logic for a series of child controllers should be places here,
 * You should remove this by your own base controller class.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 * @see			http://highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
 */
abstract class Public_Controller extends MY_Controller {

	/**
	 * Public controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
// End of Public_Controller class

/* End of file Public_Controller.php */
/* Location: ./application/core/Public_Controller.php */