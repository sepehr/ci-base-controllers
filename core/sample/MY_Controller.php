<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application SAMPLE Base Controller
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
abstract class Base_Controller extends MX_Controller {

	/**
	 * Stores current user data.
	 *
	 * @var object
	 */
	protected $user;

	//--------------------------------------------------------------------

	/**
	 * Application base controller constructor.
	 */
	public function __construct()
	{
		Events::trigger('before_controller_constructor', get_class($this));

		parent::__construct();

		Events::trigger('before_base_controller_constructor', get_class($this));

		// ------------------------------------------------------------------------
		// Early Checks
		// ------------------------------------------------------------------------
		// Maintanance mode
		if (MAINTANENCE)
		{
			// @TODO: Move the text into a config file, send a "Retry-After" header.
			show_error("Website is currently undergoing maintenance.", 503, 'Maintenance Mode');
		}

		// Browser compatibility
		$temp = $this->config->item('agent_redirect');
		if ($this->uri->uri_string() != $temp AND ! $this->_check_agent($this->config->item('agent_blacklist')))
		{
			redirect($temp);
		}

		// ------------------------------------------------------------------------
		// Component Load, User Setup
		// ------------------------------------------------------------------------
		// HACK! to make form validation callbacks work again in a CI HMVC installation
		// @see https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

		// Load authentication library (model included)
		// It tries to log the remembered user in
		$this->load->library('auth/ion_auth', '', 'auth');

		// Load up current user data if she's logged in.
		$this->user_load();

		// ------------------------------------------------------------------------
		// Environments
		// ------------------------------------------------------------------------
		// @TODO: Fetch from a config file
		date_default_timezone_set('Europe/London');

		// Production environment
		if (ENVIRONMENT == 'production')
		{
			// Production cache driver
		    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}

		// Development environment, or production with devel mode
		if (devel_mode())
		{
			// Runtime php settings
			ini_set('html_errors', 1);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			// Error reporting level is already set by CI;

			// Load development and debug libraries, also enable the profiler
			// In case that it's IE and the profiler is enabled we're not able
			// to properly serve AJAX-like iframe file uploads, so here we filter
			// all problematic request types.
			if ( ! IS_AJAX AND ! $this->input->is_cli_request()
				// Make sure that it's not a multipart HTTP request
				AND strpos($this->input->get_request_header('Content-type', TRUE), 'multipart') === FALSE)
			{
				$this->load->library('console');
				$this->output->enable_profiler(TRUE);
			}

			// Development cache driver
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'dummy'));
		}

		// Trigger events
		Events::trigger('after_base_controller_constructor', get_class($this));
		log_message('debug', 'Base Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------
	// User/Authentication Helpers
	// ------------------------------------------------------------------------

	/**
	 * Loads current user data.
	 *
	 * All derived classes should use/extend this API function to load current
	 * user's data to maintain the behavior across all the derived controllers.
	 *
	 * @requires Auth module
	 */
	protected function user_load($user_id = FALSE)
	{
		// ...
	}

	// ------------------------------------------------------------------------

	/**
	 * Auth helper: restricts access to anons.
	 *
	 * @todo This should be moved to the authentication library.
	 */
	protected function restrict($group, $message = FALSE, $activated_only = FALSE)
	{
		// ...
	}

	// ------------------------------------------------------------------------

	/**
	 * Auth helper: restricts access to loggedin users.
	 *
	 * @todo Merge with restrict() method.
	 *       This should be moved to the authentication library.
	 */
	protected function prevent($group, $message = FALSE)
	{
		// ...
	}

	// ------------------------------------------------------------------------
	// Internal Helpers
	// ------------------------------------------------------------------------

	/**
	 * Refreshes POST data.
	 *
	 * POST variables might be formatted by validation callbacks.
	 */
	protected function _refresh_post(&$post)
	{
		if (is_array($post) AND is_array($_POST))
		{
			$post = array_merge($post, $_POST);
		}

		return $post;
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks user agent and blocks user access in case of non-compatible browser.
	 *
	 * An array of default blacklisted agents are defined in "config.php" file.
	 *
	 * @param  mixed $blacklist An array of user agents with their minimum version supported.
	 *
	 * @return bool
	 */
	protected function _check_agent($blacklist = FALSE)
	{
		$this->load->library('user_agent');
		$blacklist OR $blacklist = $this->config->item('agent_blacklist');

		return ! (in_array($agent = $this->agent->browser(), array_keys($blacklist)) AND
				  version_compare($this->agent->version(), $blacklist[$agent], 'lt'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Generates a unique hash for the given array.
	 *
	 * @param  array $array Array to generate hash for.
	 * @param  bool  $flat  Whether to flatten the array first or not.
	 *
	 * @return string       MD5 hash of the array.
	 */
	public function _array_hash($array, $flat = TRUE)
	{
		static $cache;
		$array OR $array = array();

		// Memoize results, generate call hash
		$hash = md5(serialize(func_get_args()));

		if ( ! isset($cache[$hash]))
		{
			if ($flat)
			{
				$temp = array();
				foreach ($array as $key => $value)
				{
					is_array($value) OR $value = array($value);
					$temp = array_merge($temp, $value);
				}

				$array = $temp;
			}

			return $cache[$hash] = md5(serialize($array));
		}

		return $cache[$hash];
	}

	// ------------------------------------------------------------------------
	// Custom Validation Callbacks
	// ------------------------------------------------------------------------
	// ...

	// ------------------------------------------------------------------------

}
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */