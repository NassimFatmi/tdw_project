<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$signals = $this->_data["signals"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des signalements</h2>
        <table>
            <thead>
            <th>id</th>
            <th>client</th>
            <th>transporteur</th>
            <th>Objet</th>
            <th>Message</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($signals as $signal) {
                ?>
                <tr>
                    <td><?php echo $signal["signalId"]; ?></td>
                    <td><?php echo $signal["clientId"]; ?></td>
                    <td><?php echo $signal["transporteurId"]; ?></td>
                    <td><?php echo $signal["objet"]; ?></td>
                    <td><?php echo $signal["message"]; ?></td>
                    <td>
                        <a href="" class="link-btn">Voir plus</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>