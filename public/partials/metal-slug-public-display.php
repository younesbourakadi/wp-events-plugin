<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wp_project
 * @since      1.0.0
 *
 * @package    Metal_Slug
 * @subpackage Metal_Slug/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- Afficher les détails de l'événement à éditer -->
<?php
// Display the form for editing the event
if (isset($event_data)) {
?>
    <form method="POST">
        <div class="public_content-modify">
            <label class="public_content-modifyLabel" id="modifyDateStart">Début de l'événement
                <input type="datetime-local" id="modifyDateStart" class="public_content-modifyInput" name="startEvent" value="<?php echo esc_attr($event_data->start_date); ?>"></label>
        </div>

        <div class="public_content-modify">
            <label class="public_content-modifyLabel" id="modifyDateEnd">Fin de l'événement
                <input type="datetime-local" id="modifyDateEnd" class="public_content-modifyInput" name="endEvent" value="<?php echo esc_attr($event_data->end_date); ?>"></label>
        </div>

        <input type="hidden" name="action" value="update_event">
        <input type="hidden" name="event_id" value="<?php echo esc_attr($event_data->event_id); ?>">
        <input type="submit" name="submit" class="public_content-modify" value="Modifier l'événement">
    </form>
<?php
}
?>