<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Application Base Controller for administration pages.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Admin_Controller extends Front_Controller {

	/**
	 * Admin controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_admin_controller');

		// Restrict to admins
		$this->restrict('admin');

		// Load required libraries and helpers
		$this->load->library('form');
		$this->load->helper(array('url', 'form'));

		// Disable profiler on admin pages
		// $this->output->enable_profiler(FALSE);

		// Set defaults
		$this->_set_title('Administration Area');

		Events::trigger('after_admin_controller');
		log_message('debug', 'Admin Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------

	/**
	 * Temporary under construction page.
	 */
	public function construction()
	{
		$this->render(array(), 'admin/construction');
	}

	// ------------------------------------------------------------------------
	// Template helpers
	// ------------------------------------------------------------------------

	/**
	 * Admin 404 helper.
	 *
	 * @param  string $message Not found message to show.
	 *
	 * @return string
	 */
	protected function _show_404($message = FALSE)
	{
		$this->render(array('message_404' => $message), 'admin/404');
		$this->output->_display();
		exit();
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets theme.
	 *
	 * Available themes are: "default", "cvbank" and "admin".
	 *
	 * @return string Theme name
	 */
	protected function _set_theme($theme = FALSE)
	{
		// Set default admin theme name, if not passed
		$theme OR $theme = 'admin';

		Template::set_theme($theme);
		return $theme;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets template blocks.
	 *
	 * @return object
	 */
	protected function _set_blocks()
	{
		Template::set_block('header', 'blocks/header');
		Template::set_block('footer', 'blocks/footer');
		Template::set_block('sidebar', 'blocks/sidebar');
		Template::set_block('subsidebar', 'blocks/subsidebar');

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets admin asset files.
	 *
	 * @param mixed $theme Theme name.
	 *
	 * @return object
	 * @todo   Load assets on demand.
	 * @see    application/libraries/Assets.php:external_js():749
	 */
	protected function _set_assets($theme = FALSE)
	{
		// Prep theme name
		$theme = rtrim($theme, '/');

		// Add admin CSS assets
		Assets::add_css(array(
			'reset.css',
			'icons.css',
			'form-admin.css',
			'sourcerer.css',
			'jqueryui.css',
			'tipsy.css',
			'tags.css',
			'fonts.css',
			'main.css',
			'select2.css',
			'custom.css',
		));

		// Tablet behavior
		Assets::add_css('portrait.css', 'all and (orientation:portrait)');

		// Add admin JS assets
		Assets::add_js(array(
			'jquery.min.js',
			'jqueryui.min.js',
			'jquery.cookies.js',
			'jquery.pjax.js',
			'jquery.selectskin.js',
			'jquery.tipsy.js',
			'jquery.livequery.js',
			'select2.min.js',
			'timepicker.js',
			'fileuploader.js',
			'application.js',
			'custom.js',
			'ajax.js',
			'chained.js',
			'postcode.js',
			'admin_address.js',    // Admin fork of assets/js/address.js
			'admin_jobseeker.js',  // Admin fork of jobseeker/speciality.js
			'admin_speciality.js', // Admin fork of jobseeker/speciality.js
		));

		// Module assets:
		// ...

		return $this;
	}

	// ------------------------------------------------------------------------

}
// End of Admin_Controller class

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */