<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Créer news</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <form method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Titre" name="title">
            <textarea maxlength="250" placeholder="Résumé" name="summary"></textarea>
            <textarea placeholder="Article" name="article"></textarea>
            <div class="file-form">
                Article image :
                <input type="file" name="file" required accept="image/jpeg,image/jpg,image/png"/>
                <p class="error-text">L'image de produit est obligatoire</p>
            </div>
            <input class="link-btn" type="submit" name="submit" value="Créer">
        </form>
    </div>
</div>