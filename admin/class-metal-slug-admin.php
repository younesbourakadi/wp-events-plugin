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

		add_submenu_page(
			'metal-slug-admin-page',
			'Modifier un Événement',
			'Modifier un Événement',
			'administrator',
			'edit-event',
			array($this, 'display_edit_event_page')
		);
	}

	public function display_admin_page()
	{
		require_once(plugin_dir_path(__FILE__) . 'partials/metal-slug-admin-display.php');
	}

	public function display_edit_event_page()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'metal_slug_events';
		$events = $wpdb->get_results("SELECT * FROM $table_name");

		echo '<h2>Modifier un événement</h2>';
		echo '<ul>';
		foreach ($events as $event) {
			echo '<li><a href="' . admin_url('admin-post.php?action=edit_event&event_id=' . $event->id) . '">Éditer ' . esc_html($event->event_title) . '</a></li>';
		}
		echo '</ul>';
	}


	public function register_settings()
	{
		register_setting('metal-slug-settings', 'metal_slug_event_title');
		register_setting('metal-slug-settings', 'metal_slug_event_start_date');
		register_setting('metal-slug-settings', 'metal_slug_event_end_date');
	}



	public function process_add_event()
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

			wp_redirect(admin_url('?page=metal-slug-admin-page'));
			exit;
		}
	}

	public function process_edit_event()
	{
		if (isset($_GET['action']) && $_GET['action'] === 'edit_event' && isset($_GET['event_id'])) {
			$event_id = intval($_GET['event_id']);

			global $wpdb;
			$table_name = $wpdb->prefix . 'metal_slug_events';
			$event_data = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $event_id");

			echo '<h2>Éditer l\'événement</h2>';
			echo '<form method="post" action="' . admin_url('admin-post.php?action=update_event') . '">';
			echo '<input type="hidden" name="action" value="update_event">';
			echo '<input type="hidden" name="event_id" value="' . esc_attr($event_id) . '">';

			echo '<div class="admin_content-modify">';
			echo '<label class="admin_content-modifyLabel" id="modifyName">Nom de l\'événement';
			echo '<input type="text" id="modifyName" class="admin_content-modifyInput" name="titleEvent" placeholder="Nom de l\'événement" value="' . esc_attr($event_data->event_title) . '"></label>';
			echo '</div>';

			echo '<div class="admin_content-modify">';
			echo '<label class="admin_content-modifyLabel" id="modifyDateStart">Début de l\'événement';
			echo '<input type="datetime-local" id="modifyDateStart" class="admin_content-modifyInput" name="startEvent" value="' . esc_attr(str_replace(' ', 'T', $event_data->start_date)) . '"></label>';
			echo '</div>';

			echo '<div class="admin_content-modify">';
			echo '<label class="admin_content-modifyLabel" id="modifyDateEnd">Fin de l\'événement';
			echo '<input type="datetime-local" id="modifyDateEnd" class="admin_content-modifyInput" name="endEvent" value="' . esc_attr(str_replace(' ', 'T', $event_data->end_date)) . '"></label>';
			echo '</div>';

			echo '<input type="submit" name="submit" class="admin_content-modify" value="Modifier l\'événement">';
			echo '</form>';
		}
	}

	public function process_update_event()
	{
		if (isset($_POST['titleEvent']) && isset($_POST['startEvent']) && isset($_POST['endEvent']) && isset($_POST['event_id'])) {
			$event_id = intval($_POST['event_id']);

			// Mettre à jour les données de l'événement dans la base de données
			global $wpdb;
			$table_name = $wpdb->prefix . 'metal_slug_events';
			$titleEvent = sanitize_text_field($_POST['titleEvent']);
			$startEvent = sanitize_text_field($_POST['startEvent']);
			$endEvent = sanitize_text_field($_POST['endEvent']);
			$data = array(
				'event_title' => $titleEvent,
				'start_date' => $startEvent,
				'end_date' => $endEvent
			);

			$where = array('id' => $event_id);
			$wpdb->update($table_name, $data, $where);

			wp_redirect(admin_url('?page=metal-slug-admin-page'));
			exit;
		}
	}

	public function process_delete_event()
	{
		if (isset($_POST['event_id']) && $_POST['action'] === 'supprimer_evenement') {
			$event_id = intval($_POST['event_id']);

			global $wpdb;
			$table_name = $wpdb->prefix . 'metal_slug_events';
			$where = array('id' => $event_id);
			$wpdb->delete($table_name, $where);

			wp_redirect(admin_url('?page=metal-slug-admin-page'));
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
