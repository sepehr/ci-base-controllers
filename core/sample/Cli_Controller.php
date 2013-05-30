<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Application CLI Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Cli_Controller extends Base_Controller {

	/**
	 * CLI controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_cli_controller');

		// Restrict to CLI use only
		if ( ! $this->input->is_cli_request() AND ENVIRONMENT != 'development')
		{
			show_error('You are not allowed to view this page :)', 403, '403 Unauthorized Access');
		}

		// Load CLI interface
		$this->load->library('cli');

		Events::trigger('after_cli_controller');
		log_message('debug', 'CLI Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------

}
// End of Cli_Controller class

/* End of file Cli_Controller.php */
/* Location: ./application/core/Cli_Controller.php */