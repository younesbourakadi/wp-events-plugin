<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp_project
 * @since      1.0.0
 *
 * @package    Metal_Slug
 * @subpackage Metal_Slug/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Metal_Slug
 * @subpackage Metal_Slug/admin
 * @author     JCVD <yolo@bisous.org>
 */
class Metal_Slug_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function add_admin_menu()
	{
		add_menu_page(
			'Gestion des Événements',
			'Événements',
			'administrator',
			'metal-slug-admin-page',
			array($this, 'display_admin_page')
		);
	}

	public function display_admin_page()
	{
		require_once(plugin_dir_path(__FILE__) . 'partials/metal-slug-admin-display.php');
	}


	public function register_settings()
	{
		register_setting('metal-slug-settings', 'metal_slug_event_title');
		register_setting('metal-slug-settings', 'metal_slug_event_start_date');
		register_setting('metal-slug-settings', 'metal_slug_event_end_date');
	}



	public function process_ajouter_evenement()
	{

		if (isset($_POST['titleEvent']) && isset($_POST['startEvent']) && isset($_POST['endEvent'])) {

			// Récupérer les données du formulaire
			$titleEvent = sanitize_text_field($_POST['titleEvent']);
			$startEvent = sanitize_text_field($_POST['startEvent']);
			$endEvent  = sanitize_text_field($_POST['endEvent']);

			global $wpdb;
			$table_name = $wpdb->prefix . 'metal_slug_events';
			$data = array(
				'event_title' => $titleEvent,
				'start_date' => $startEvent,
				'end_date' => $endEvent,

			);
			$wpdb->insert($table_name, $data);
			var_dump($data);

			// wp_redirect(admin_url('?page=metal-slug-admin-page'));
			exit;
		}
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Metal_Slug_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metal_Slug_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/metal-slug-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Metal_Slug_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metal_Slug_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/metal-slug-admin.js', array('jquery'), $this->version, false);
	}
}
