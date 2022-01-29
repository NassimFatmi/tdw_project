<?php
$dashboardView = new \TDW\VIEWS\Dashboard\DashboardView();
\TDW\Templates\Templates::showMessages();
$demandes = $this->_data["clientDemandes"];
$tdemandes = $this->_data["transporteursDemandes"];
?>
<div class="admin">
    <?php $dashboardView->adminNavbar(); ?>
    <div class="content">
        <h2 class="secondary-heading">Les demandes </h2>
        <p>Les demandes valident par les transporteurs</p>
        <table>
            <thead>
            <th>Id</th>
            <th>Annonce Numéro</th>
            <th>Transporteur</th>
            <th>Email</th>
            <th>Tél</th>
            <th>Date</th>
            <th>Satisfait</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            if (!isset($demandes)) echo "Aucun demandes...";
            else
                foreach ($demandes as $demande) {
                    ?>
                    <tr>
                        <td><?php echo $demande["id"]; ?></td>
                        <td><?php echo $demande["annonceId"]; ?></td>
                        <td><?php echo $demande["tnom"] . " " . $demande["tprenom"]; ?></td>
                        <td><?php echo $demande["temail"]; ?></td>
                        <td><?php echo $demande["tphone"]; ?></td>
                        <td><?php echo $demande["created_at"]; ?></td>
                        <td><?php echo $demande["fin"] == true ? "Oui" : "Non"; ?></td>
                        <td>
                            <a class="link-btn" href="/profile/summary/transporteur/<?php echo $demande["tid"]; ?>">Voir
                                transporteur profile</a>
                            <a class="link-btn" href="/annonce/details/<?php echo $demande["annonceId"]; ?>">Voir
                                annonce</a>
                            <?php if ($demande["fin"] == false) {
                                ?>
                                <a class="link-btn yellow"
                                   href="/dashboard/satisfaittransporteur/<?php echo $demande["id"]; ?>">Satisfait</a>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
        <br>
        <p>Les demandes valident par les clients</p>
        <table>
            <thead>
            <th>Id</th>
            <th>Annonce Numéro</th>
            <th>Transporteur</th>
            <th>Email</th>
            <th>Tél</th>
            <th>Date</th>
            <th>Satisfait</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php
            if (!isset($tdemandes)) echo "Aucun demandes...";
            else
                foreach ($tdemandes as $tdemande) {
                    ?>
                    <tr>
                        <td><?php echo $tdemande["id"]; ?></td>
                        <td><?php echo $tdemande["annonceId"]; ?></td>
                        <td><?php echo $tdemande["tnom"] . " " . $tdemande["tprenom"]; ?></td>
                        <td><?php echo $tdemande["temail"]; ?></td>
                        <td><?php echo $tdemande["tphone"]; ?></td>
                        <td><?php echo $tdemande["created_at"]; ?></td>
                        <td><?php echo $tdemande["fin"] == true ? "Oui" : "Non"; ?></td>
                        <td>
                            <a class="link-btn" href="/profile/summary/transporteur/<?php echo $tdemande["tid"]; ?>">Voir
                                transporteur profile</a>
                            <a class="link-btn" href="/annonce/details/<?php echo $tdemande["annonceId"]; ?>">Voir
                                annonce</a>
                            <?php if ($tdemande["fin"] == false) {
                                ?>
                                <a class="link-btn yellow"
                                   href="/dashboard/satisfaitclient/<?php echo $tdemande["id"]; ?>">Satisfait</a>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
