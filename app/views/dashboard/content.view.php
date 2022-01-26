<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion de contenu</h2>
    </div>
</div>