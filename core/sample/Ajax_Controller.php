<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Application AJAX Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Ajax_Controller extends Base_Controller {

	/**
	 * Stores response HTML encode mode.
	 */
	protected $_encode = FALSE;

	/**
	 * Stores response content type.
	 */
	protected $_content_type = 'application/json';

	// ------------------------------------------------------------------------

	/**
	 * AJAX controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_ajax_controller');

		// Restrict to Ajax requests only
		if ( ! IS_AJAX AND ! devel_mode())
		{
			show_error('You are not allowed to view this page :)', 403, '403 Unauthorized Access');
		}

		// Disable the profiler
		$this->output->enable_profiler(FALSE);

		Events::trigger('after_ajax_controller');
		log_message('debug', 'AJAX Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------

	/**
	 * Request response generator.
	 */
	public function response($response = array(), $add_success = TRUE, $code = '200')
	{
		is_object($response) AND $response = (array) $response;
		is_array($response)  OR  $response = array('message' => $response);

		// Prep response
		$add_success AND $response = array('success' => TRUE) + $response;
		$response = $this->_encode
			? htmlspecialchars(json_encode($response), ENT_NOQUOTES)
			: json_encode($response);

		// Using CI output class API to enbale caching for ajax requests
		$this->output
			->set_status_header($code)
			->set_content_type($this->_content_type)
			->set_output($response)
			->_display();

		exit();
	}

	// ------------------------------------------------------------------------

	/**
	 * Request error generator.
	 */
	public function error($message = 'Invalid request!', $code = '400')
	{
		$response = array('error' => $message);
		$response = $this->_encode
			? htmlspecialchars(json_encode($response), ENT_NOQUOTES)
			: json_encode($response);

		$this->output
			->set_status_header($code)
			->set_content_type($this->_content_type)
			->set_output($response)
			->_display();

		exit();
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets response content type.
	 */
	public function set_content_type($content_type)
	{
		$this->_content_type = $content_type;
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets HTML encode mode.
	 */
	public function encode($encode_mode)
	{
		$this->_encode = $encode_mode;
		return $this;
	}

	// ------------------------------------------------------------------------

}
// End of Ajax_Controller class

/* End of file Ajax_Controller.php */
/* Location: ./application/core/Ajax_Controller.php */