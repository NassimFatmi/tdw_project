<?php
$annonceId = $this->_data["annonceId"];
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();

?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <section class="adminAction">
            <h2 class="secondary-heading">
                Vérification de l'annonce numéro <?php echo $annonceId;?>
            </h2>
            <p>Pour vérifier l'annonce il faut ajouter le prix</p>
            <form method="POST">
                <input type="number" placeholder="prix en DA" name="prix" required>
                <input class="link-btn" type="submit" value="Vérifier" name="submit">
            </form>
        </section>
    </div>
</div>
