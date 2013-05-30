<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Application REST API Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 * @see			http://highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
 */
abstract class Api_Controller extends REST_Controller {

	/**
	 * Public controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------

}
// End of Api_Controller class

/* End of file Api_Controller.php */
/* Location: ./application/core/Api_Controller.php */