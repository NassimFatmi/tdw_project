<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$clients = $this->_data["clients"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des clients</h2>
        <table>
            <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Tél</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($clients as $client) {
                ?>
                <tr>
                    <td><?php echo $client["clientId"]; ?></td>
                    <td><?php echo $client["nom"]; ?></td>
                    <td><?php echo $client["prenom"]; ?></td>
                    <td><?php echo $client["email"]; ?></td>
                    <td><?php echo $client["phone"]; ?></td>
                    <td>
                        <a class="link-btn" href="/dashboard/client/<?php echo $client["clientId"]; ?>">Voir profile</a>
                        <a class="link-btn red" href="/dashboard/client/<?php echo $client["clientId"]; ?>">Ban</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>