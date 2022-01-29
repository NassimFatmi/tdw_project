<?php

use TDW\LIB\File;

$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$certificats = $this->_data["certifier"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des certification</h2>
        <table>
            <thead>
            <th>Id</th>
            <th>Transporteur Numéro</th>
            <th>Objet</th>
            <th>Contenu</th>
            <th>Attachement</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            if (!$certificats) echo "Il n'y a pas de news";
            else
                foreach ($certificats as $certificat) {
                    ?>
                    <tr>
                        <td><?php echo $certificat["id"]; ?></td>
                        <td><?php echo $certificat["transporteurId"]; ?></td>
                        <td><?php echo $certificat["title"]; ?>
                        <td><?php echo $certificat["description"]; ?></td>
                        <td>
                            <a href="<?php echo File::searchFile('certifications', 'certifcat', $certificat["id"]); ?>">
                                Voir l'attachement
                            </a>
                        </td>
                        <td>
                            <a class="link-btn"
                               href="/profile/summary/transporteur/<?php echo $certificat["transporteurId"]; ?>">Voir
                                profile</a>
                            <?php
                            if (!$certificat["done"]) {
                                ?>
                                <a class="link-btn"
                                   href="/dashboard/verifier/<?php echo $certificat["id"] . "/" . $certificat["transporteurId"]; ?>">Vérifier</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>