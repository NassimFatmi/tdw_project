<?php
$profileView = new \TDW\VIEWS\Profile\ProfileView();
$profileView->renderDefault();
$profileView->createCover($this->_data['user']);
$currentUser = $this->_data['user'];
?>
<section class="user-info">
    <ul class="tabs">
        <li class="active" data-tab="0">A propos</li>
        <?php
        if (is_a($_SESSION["user"], \TDW\Models\Client::class)) {
            ?>
            <li data-tab="1">Historique</li>
            <?php
        }
        if (is_a($_SESSION["user"], \TDW\Models\Transporteur::class)) {
            ?>
            <li data-tab="3">Demandes</li>
            <?php
        }
        ?>
        <li data-tab="2">Transaction</li>
    </ul>
    <div class="view container">
        <div class="tab show">
            <a class="link-btn" href="/profile/modifier/<?php echo $currentUser->getId(); ?>">
                <i class="fas fa-edit"></i>
                Modifier Mes informations
            </a>
            <h4>Information générale</h4>
            <ul>
                <li>
                    Nom: <span><?php echo $currentUser->getName(); ?></span>
                </li>
                <li>
                    Prenom: <span><?php echo $currentUser->getLastName(); ?></span>
                </li>
            </ul>
            <hr/>
            <h4>Adresse</h4>
            <?php $clientAdresse = $currentUser->getAdresse(); ?>
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
                    Email: <span><?php echo $currentUser->getEmail(); ?></span>
                </li>
                <li>
                    Téléphone: <span><?php echo $currentUser->getPhone(); ?></span>
                </li>
            </ul>
            <?php
            if (is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) {
                ?>
                <h4>Les trajets</h4>
                <ul>
                    <?php
                    $trajets = $currentUser->getTrajets();
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
        <div class="tab">
            <div class="annonces">
                <?php
                $userAnnonces = $this->_data['latestUserAnnonces'];
                foreach ($userAnnonces as $annonce) {
                    ?>
                    <article class="card">
                        <img src="<?php
                        echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonce->getAnnonceId());
                        ?>" alt="annonce-img"/>
                        <div class="text">
                            <div>
                                <h3><?php echo $annonce->getDescription(); ?></h3>
                                <div>Wilaya de départ :
                                    <span><?php echo $annonce->getPointDepart()->getWilaya(); ?></span></div>
                                <div>Wilaya d'arrivé :
                                    <span><?php echo $annonce->getPoinArrive()->getWilaya(); ?></span></div>

                                <div class="status">Status :
                                    <span><?php echo $annonce->isVerified() ? 'Validé' : 'En attente de validation'; ?></span>
                                </div>
                                <div>
                                    <?php
                                    $prix = $annonce->getPrix();
                                    if (isset($prix)) {
                                        ?>
                                        <h3 class="prix">Prix: <?php echo $prix; ?> DA</h3>
                                        <?php
                                    }
                                    ?>
                                    <a class="link-btn" href="/annonce/details/<?php echo $annonce->getAnnonceId(); ?>">Voir
                                        plus</a>

                                    <?php
                                    if (!$annonce->isFinished()) {
                                        ?>
                                        <a class="link-btn delete"
                                           href="/annonce/delete/<?php echo $annonce->getAnnonceId(); ?>">Supprimer</a>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="success-text">Satistfait</span>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!$annonce->isFinished() && $annonce->isVerified()) {
                                        ?>
                                        <a class="link-btn" href="/annonce/find/<?php echo $annonce->getAnnonceId(); ?>"
                                        >Chercher un transporteur</a>
                                    <?php } ?>
                                </div>
                            </div>
                    </article>
                    <?php
                }
                ?>
            </div>
            <div class="see-more">
                <a href="/profile/annonces/<?php echo $currentUser->getId(); ?>" class="link-btn">Voir tous</a>
            </div>
        </div>
        <div class="tab">
            <div class="transactions">
                <?php
                $transactions = $this->_data['transactions'];

                $total = 0;
                foreach ($transactions as $transaction) {
                    $total += $transaction['prix'];
                }
                ?>
                <h3 class="secondary-heading">
                    <?php
                    if (is_a($_SESSION['user'], \TDW\Models\Client::class)) {
                        echo 'Vous avez payé :';
                    } else {
                        echo 'Votre profit est :';
                    }
                    ?>
                    <span><?php echo $total; ?> DA</span></h3>
                <?php
                foreach ($transactions as $transaction) {
                    ?>
                    <article class="card">
                        Transaction de : <span><?php echo $transaction['prix']; ?> DA</span> Le
                        <span><?php echo $transaction['created_at']; ?>
                    </article>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) {
            ?>
            <div class="tab">
                <div class="demandes">
                    <?php
                    $demandes = $this->_data['demandes'];
                    foreach ($demandes as $demande) {
                        ?>
                        <article class="card">
                            <img src="<?php
                            echo \TDW\LIB\File::searchFile('annonces', 'annonce', $demande['annonceId']);
                            ?>" alt="annonce-img"/>
                            <div class="text">
                                <div>
                                    <h3><?php echo $demande['description']; ?></h3>

                                    <?php
                                    if ($demande['done']) {
                                        ?>
                                        <span class="success-text">Finie</span>
                                        <?php
                                    } elseif ($demande["refuser"]) {
                                        ?>
                                        <span class="error-text">Refuser</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="alert-text">En attente</span>
                                        <?php
                                    }
                                    ?>
                                    <a class="link-btn" href="/annonce/details/<?php echo $demande['annonceId']; ?>">Voir
                                        plus</a>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<script>
    const tabsLinks = document.querySelectorAll('.user-info .tabs li');
    tabsLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            tabsLinks.forEach(tabLink => tabLink.classList.remove('active'));
            e.target.classList.add('active');
            const tabs = document.querySelectorAll('.user-info .view .tab');
            tabs.forEach(tab => tab.classList.remove('show'));
            tabs[e.target.dataset.tab].classList.add('show');
        });
    });
</script>