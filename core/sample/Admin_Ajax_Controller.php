<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Admin AJAX Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Admin_Ajax_Controller extends Ajax_Controller {

	/**
	 * Admin AJAX controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_admin_ajax_controller');

		// Restrict to admin users only
		if ( ! $this->auth->in_group('admin'))
		{
			show_error('You are not allowed to view this page :)', 403, '403 Unauthorized Access');
		}

		// Form validation
		$this->load->library('form');

		// Get form name
		$form = isset($_GET['form_name'])
			? $_GET['form_name']
			: isset($_POST['form_name']) ? $_POST['form_name'] : FALSE;

		// Check for errors if any
		if ($form AND ! Form::validate($form))
		{
			$this->error(Form::errors(TRUE));
		}

		// Prep post fields
		$this->_prep_post();

		Events::trigger('after_admin_ajax_controller');
		log_message('debug', 'Admin AJAX Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------
	// Internal Helpers
	// ------------------------------------------------------------------------
	// ...

	// ------------------------------------------------------------------------

}
// End of Admin_Ajax_Controller class

/* End of file Admin_Ajax_Controller.php */
/* Location: ./application/core/Admin_Ajax_Controller.php */