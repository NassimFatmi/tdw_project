<?php
$user = $this->_data["user"];
$profileView = new \TDW\VIEWS\Profile\ProfileView();
$profileView->createSummary($this->_data['user']);

?>
<section class="summary">
    <div class="container">
        <h2 class="secondary-heading">Profile Utilisateur</h2>
        <div class="tab show">
            <h4>Information générale</h4>
            <ul>
                <li>
                    Nom: <span><?php echo $user->getName(); ?></span>
                </li>
                <li>
                    Prenom: <span><?php echo $user->getLastName(); ?></span>
                </li>
            </ul>
            <hr/>
            <h4>Adresse</h4>
            <?php $clientAdresse = $user->getAdresse(); ?>
            <ul>
                <li>
                    Adresse: <span><?php echo $clientAdresse->getAdresseExacte(); ?></span>
                </li>
                <li>
                    Commune: <span><?php echo $clientAdresse->getCommune(); ?></span>
                </li>
                <li>
                    Wilaya: <span><?php echo $clientAdresse->getWilaya(); ?></span>
                </li>
            </ul>
            <hr/>
            <h4>Autre</h4>
            <ul>
                <li>
                    Email: <span><?php echo $user->getEmail(); ?></span>
                </li>
                <li>
                    Téléphone: <span><?php echo $user->getPhone(); ?></span>
                </li>
            </ul>
            <?php
            if (is_a($user, \TDW\Models\Transporteur::class)) {
                ?>
                <h4>Les trajets</h4>
                <ul>
                    <?php
                    $trajets = $user->getTrajets();
                    foreach ($trajets as $trajet) {
                        $wilayaNom = \TDW\Models\Wilaya::getWilaya($trajet->getWilayaId());
                        ?>
                        <li><?php echo $wilayaNom->getName(); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</section>
