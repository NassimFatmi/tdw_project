<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$signal = $this->_data["signal"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading"># <?php echo $signal->getSignalId();?> Signalement details</h2>
        <div class="signal-details card text">
            <h3><?php echo $signal->getObjet();?></h3>
            <ul>
                <li>De : <?php echo $signal->getClient();?></li>
                <li>Transporteur :  <?php echo $signal->getTransporteur();?></li>
            </ul>
            <p>
                <?php echo $signal->getMessage();?>
            </p>
        </div>
    </div>
</div>