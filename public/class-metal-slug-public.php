<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp_project
 * @since      1.0.0
 *
 * @package    Metal_Slug
 * @subpackage Metal_Slug/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Metal_Slug
 * @subpackage Metal_Slug/public
 * @author     JCVD <yolo@bisous.org>
 */
class Metal_Slug_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/metal-slug-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/metal-slug-public.js', array('jquery'), $this->version, false);
	}


	public function display_events_content()
	{
		// Récupérer les événements depuis la base de données
		global $wpdb;
		$table_name = $wpdb->prefix . 'metal_slug_events';
		$events = $wpdb->get_results("SELECT * FROM $table_name");

		// Générer le contenu HTML des événements
		$event_content = '<div id="metal-slug-events">';
		$event_content .= '<h2>Événements à venir :</h2>';

		if ($events) {
			$event_content .= '<ul>';
			foreach ($events as $event) {
				$event_content .= '<li>';
				$event_content .= '<strong>' . esc_html($event->event_title) . '</strong><br>';
				$event_content .= 'Début : ' . esc_html($event->start_date) . '<br>';
				$event_content .= 'Fin : ' . esc_html($event->end_date);
				$event_content .= '</li>';
			}
			$event_content .= '</ul>';
		} else {
			$event_content .= '<p>Aucun événement à venir.</p>';
		}

		$event_content .= '</div>';

		echo $event_content;
	}

	public function process_add_event_public()
	{

		if (isset($_POST['titleEvent']) && isset($_POST['startEvent']) && isset($_POST['endEvent'])) {

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

	public function process_edit_event_public()
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
}

// $metal_slug_public = new Metal_Slug_Public('Metal Slug', '1.0.0');
