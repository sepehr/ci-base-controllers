<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAMPLE Application Front Controller for themed pages.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Front_Controller extends Base_Controller {

	/**
	 * Front controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_front_controller');

		// Load template and assets libraries, set theme, etc.
		$this->load->library(array('assets', 'template'));

		// Set template theme
		$theme = $this->_set_theme();

		// Set blocks, assets, body classes and breadcrumb vars
		$this->_set_blocks()
			->_set_assets($theme)
			->_set_body_classes()
			->_set_breadcrumb();

		// Make sure that template placeholders are available
		$this->load->vars(array(
			'base'           => base_url(),
			'title'          => 'SITE TITLE',
			// Metas
			'head'           => '',
			// Expose URI segments as an array
			'segments'       => $this->uri->segment_array(),
			// Request URIs
			'previous_page'  => $this->previous_page,
			'requested_page' => $this->requested_page,
		));

		Events::trigger('after_front_controller');
		log_message('debug', 'Front Controller Class Initialized.');
	}

	// ------------------------------------------------------------------------
	// Template helpers
	// ------------------------------------------------------------------------

	/**
	 * Template renderrer helper, uses Template & Form libraries.
	 *
	 * @param  array  $data   View data array.
	 * @param  string $data   View name (modular).
	 * @param  string $layout Layout to render the view in.
	 *
	 * @return void
	 *
	 * @todo   Language class integration.
	 * @todo   Implement the ability to handle pagination AJAX requests.
	 */
	protected function render($data = FALSE, $view = FALSE, $layout = '')
	{
		if ($data)
		{
			// Set view vars
			foreach ($data as $key => $value)
			{
				// Render forms
				if ($value AND strpos($key, 'form') !== FALSE AND ! is_array($value) AND strlen($value) < 70)
				{
					$value = Form::get($value);
				}

				// Render breadcrumbs
				if ($key == 'breadcrumb' AND is_array($value))
				{
					$value = breadcrumb($value);
				}

				// Pass to the view
				Template::set($key, $value);
			}
		}

		// Set view file
		$view AND Template::set_view($view);

		// Render in layout
		Template::render($layout);
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets theme.
	 *
	 * Available themes are: "default", "test" and "admin".
	 *
	 * @return string Theme name
	 */
	protected function _set_theme($theme = FALSE)
	{
		// Get default theme name, if not passed
		$theme OR $theme = $this->config->item('template.default_theme');

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
		Template::set_block('navbar', 'blocks/navbar');
		Template::set_block('footer', 'blocks/footer');
		Template::set_block('breadcrumb', 'blocks/breadcrumb');

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets controller asset files.
	 *
	 * @param mixed $theme Theme name.
	 *
	 * @return object
	 */
	protected function _set_assets($theme = FALSE)
	{
		// Prep theme name
		$theme = rtrim($theme, '/');

		// Add general CSS assets
		Assets::add_css('select2.css');
		Assets::add_css('bootstrap.min.css');
		Assets::add_css('bootstrap-responsive.min.css');

		// Add general JS assets
		// @TODO: Move module specific files to their own module
		// and load them as per required...
		Assets::add_js('jquery.min.js');
		Assets::add_js('modernizr.min.js');
		Assets::add_js('bootstrap.js');
		Assets::add_js('select2.min.js');
		Assets::add_js('application.js');

		// Load theme specific assets
		Assets::add_js("$theme.js");
		Assets::add_css("$theme.css");

		// @TODO: Themes should be able to add their own assets.

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets page title variable.
	 *
	 * @param string $title Page title.
	 *
	 * @return object
	 */
	protected function _set_title($title)
	{
		is_string($title) AND $this->load->vars(array('title' => $title));
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets page breadcrumb trail.
	 *
	 * @param array $breadcrumb Array of breadcrumb segments.
	 *
	 * @return object
	 */
	protected function _set_breadcrumb($breadcrumb = NULL)
	{
		is_array($breadcrumb) OR $breadcrumb = NULL;

		$this->load->vars(array('breadcrumb' => breadcrumb($breadcrumb)));
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns body classes string.
	 *
	 * @return string
	 */
	protected function _set_body_classes($uri = TRUE, $agent = TRUE, $return = FALSE)
	{
		$classes = '';

		// Add URI segments
		$uri AND $classes .= $this->uri->uri_string()
			? str_replace('/', ' ', $this->uri->uri_string())
			: 'front';

		// And agent specs
		$agent AND $classes .= ' ' . body_classes();

		$this->load->vars(array('body_classes' => $classes));
		return $return ? $classes : $this;
	}

	// ------------------------------------------------------------------------
	// Internal Helpers
	// ------------------------------------------------------------------------

	/**
	 * Renders passed data into HTML template for debugging.
	 *
	 * @todo Check if XDebug is available...
	 */
	protected function debug()
	{
        ob_start();

		// Dump each var
		foreach (func_get_args() as $arg)
		{
			var_dump($arg);
			echo '<hr />';
		}

		$output = ob_get_contents();
        ob_end_clean();

        // Render in simple template
        $this->render(array(
        	'content'  => $output,
        	'subtitle' => 'DEBUG',
        ), 'system/default', 'simple');
	}

	// ------------------------------------------------------------------------

}
// End of Front_Controller class

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */