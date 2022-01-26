<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$transporteurs = $this->_data["transporteurs"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des transporteurs</h2>
        <table>
            <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Tél</th>
            <th>Certifier</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($transporteurs as $transporteur) {
                ?>
                <tr>
                    <td><?php echo $transporteur["transporteurId"]; ?></td>
                    <td><?php echo $transporteur["nom"]; ?></td>
                    <td><?php echo $transporteur["prenom"]; ?></td>
                    <td><?php echo $transporteur["email"]; ?></td>
                    <td><?php echo $transporteur["phone"]; ?></td>
                    <td><?php echo $transporteur["certifier"] ? "Oui" : "Non"; ?></td>
                    <td>
                        <a class="link-btn" href="/dashboard/client/<?php echo $transporteur["transporteurId"]; ?>">Voir
                            profile</a>
                        <a class="link-btn red" href="/dashboard/client/<?php echo $transporteur["transporteurId"]; ?>">Ban</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>