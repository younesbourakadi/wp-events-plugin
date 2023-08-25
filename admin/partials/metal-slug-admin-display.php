    <?php

    /**
     * Provide a admin area view for the plugin
     *
     * This file is used to markup the admin-facing aspects of the plugin.
     *
     * @link       https://wp_project
     * @since      1.0.0
     *
     * @package    Metal_Slug
     * @subpackage Metal_Slug/admin/partials
     */
    ?>

    <section class="admin_title">
        <h1 class="admin_title-main">MetalSlug page d'administration</h1>
    </section>

    <section class="admin_content">

        <article class="admin_content-formEvent">
            ​
            <h2 class="admin_content-consultTitle">Consuler les évènements</h2>
            ​
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'metal_slug_events';
            $results = $wpdb->get_results("SELECT * FROM $table_name");
            ?>
            ​
            <div class="admin_content-consult">
                <!-- <ul> -->
                <?php foreach ($results as $result) :
                    $startDate = new DateTime($result->start_date);
                    $endDate = new DateTime($result->end_date);
                ?>
                    <ul class="admin_content-list">
                        <li class="admin_content-listTitle">
                            <h3><?php echo $result->event_title; ?></h3>
                        </li>
                        <li class="admin_content-listContent"><strong>Date de début : </strong><?php echo $startDate->format('j F Y'); ?></li>
                        <li class="admin_content-listContent"><strong>Heure de début : </strong><?php echo $startDate->format('H:i'); ?></li>
                        <li class="admin_content-listContent"><strong>Date de fin : </strong><?php echo $endDate->format('j F Y'); ?></li>
                        <li class="admin_content-listContent"><strong>Heure de fin : </strong><?php echo $endDate->format('H:i'); ?></li>
                    </ul>
                <?php endforeach; ?>
            </div>
            ​
            <article class="admin_content-formEvent">

                <h2 class="admin_content-addTitle">Ajouter un évènement</h2>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="add_event">

                    <div class="admin_content-add">
                        <label class="admin_content-addLabel" id="addName">Nom de l'évènement
                            <input type="text" id="addName" class="admin_content-addInput" name="titleEvent" placeholder="Nom de l'évènement"></label>
                    </div>

                    <div class="admin_content-add">
                        <label class="admin_content-addLabel" id="addDateStart">Début de l'évènement
                            <input type="datetime-local" id="addDateStart" class="admin_content-addInput" name="startEvent" placeholder="Début de l'évènement"></label>
                    </div>
                    ​
                    <div class="admin_content-add">
                        <label class="admin_content-addLabel" id="addDateEnd">Fin de l'évènement
                            <input type="datetime-local" id="addDateEnd" class="admin_content-addInput" name="endEvent" placeholder="Fin de l'évènement"></label>
                    </div>
                    ​
                    <input type="submit" name="submit" class="admin_content-add" value="Créer l'évènement">
                </form>
            </article>
            ​


            <article class="admin_content-formEvent">
                ​
                <h2 class="admin_content-deleteTitle">Supprimer un évènement</h2>
                ​
                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'metal_slug_events';
                $results = $wpdb->get_results("SELECT * FROM $table_name");

                ?>
                ​
                <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=metal-slug-admin-page')); ?>">
                    <input type="hidden" name="action" value="supprimer_evenement">
                    ​
                    <div class="admin_content-delete">
                        <label for="delEvent">Sélectionner un évènement à supprimer
                            <select name="event_id" id="delEvent">
                                <option value="" selected>Choisir un évènement</option>
                                <?php foreach ($results as $result) {
                                    var_dump($result);
                                    echo "<option value='" . esc_attr($result->id) . "'>" . esc_html($result->event_title) . "</option>";
                                } ?>
                            </select>
                        </label>
                    </div>
                    ​
                    <input type="submit" name="submit" class="admin_content-modify" value="Supprimer l'évènement">
                </form>
                ​
            </article>
    </section>