<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
$annonces = $this->_data["annonces"];
\TDW\Templates\Templates::showMessages();
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Gestion des annonces</h2>
        <form method="post">
            <h3>Filtres</h3>
            <label>
                Les annonces vérifiées
                <input type="checkbox" name="verifier">
            </label>
            <label>
                Les annonces satisfaites
                <input type="checkbox" name="finished">
            </label>
            <label>
                Les annonces archivées
                <input type="checkbox" name="archive">
            </label>
            <input class="link-btn" type="submit" value="Filtrer" name="submit">
        </form>
        <table>
            <thead>
            <th>Id</th>
            <th>Description</th>
            <th>Date</th>
            <th>Vérifier</th>
            <th>Satisfait</th>
            <th>Archivé</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($annonces as $annonce) {
                ?>
                <tr>
                    <td><?php echo $annonce["annonceId"]; ?></td>
                    <td><?php echo $annonce["description"]; ?></td>
                    <td><?php echo $annonce["created_at"]; ?></td>
                    <td><?php echo $annonce["verifier"] ? "Oui" : "Non"; ?></td>
                    <td><?php echo $annonce["finished"] ? "Oui" : "Non"; ?></td>
                    <td><?php echo $annonce["archive"] ? "Oui" : "Non"; ?></td>
                    <td>
                        <?php if (!$annonce["verifier"]) { ?>
                            <a class="link-btn green"
                               href="/dashboard/verifierannonce/<?php echo $annonce["annonceId"]; ?>">Verifier</a>
                        <?php } ?>
                        <?php if (!$annonce["archive"]) { ?>
                            <a class="link-btn red"
                               href="/dashboard/deleteannonce/<?php echo $annonce["annonceId"]; ?>">Supprimer</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
