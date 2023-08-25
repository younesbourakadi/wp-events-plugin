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

            <h2 class="admin_content-modifyTitle">Modifier un évènement</h2>
            ​
            <form method="POST">
                <div class="admin_content-modify">
                    <label class="admin_content-modifyLabel" id="modifyName">Nom de l'évènement
                        <input type="text" id="modifyName" class="admin_content-modifyInput" name="titleEvent" placeholder="Nom de l'évènement"></label>
                </div>

                <div class="admin_content-modify">
                    <label class="admin_content-modifyLabel" id="modifyDateStart">Début de l'évènement
                        <input type="datetime-local" id="modifyDateStart" class="admin_content-modifyInput" name="startEvent" placeholder="Début de l'évènement"></label>
                </div>
                ​
                <div class="admin_content-modify">
                    <label class="admin_content-modifyLabel" id="modifyDateEnd">Fin de l'évènement
                        <input type="datetime-local" id="modifyDateEnd" class="admin_content-modifyInput" name="endEvent" placeholder="Fin de l'évènement"></label>
                </div>
                ​
                <input type="submit" name="submit" class="admin_content-modify" value="Modifier l'évènement">
            </form>
        </article>
        <article class="admin_content-formEvent">
            ​
            <h2 class="admin_content-modifyTitle">Supprimer un évènement</h2>
            ​
        </article>
        <article class="admin_content-formEvent">
            .
        </article>
    </section>