<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content"></div>
</div>
