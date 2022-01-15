<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="annonces-list">
    <div class="container">
        <h2 class="secondary-heading">Vos annonces</h2>
        <div class="content">
            <?php
            $userAnnonces = $this->_data['annonces'];
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
                                    >Chercher un
                                        transporteur</a>
                                <?php } ?>
                            </div>
                        </div>
                </article>
                <?php
            }
            ?>
        </div>
        <div class="select-page">
            <?php if (isset($this->_params[1]) && $this->_params[1] != 0) {
                ?>
                <a class="link-btn"
                   href="/profile/annonces/<?php echo $_SESSION['user']->getId(); ?>/<?php echo($this->_params[1] - 1); ?>"><i
                            class="fas fa-arrow-left"></i></a>
                <?php
            }
            ?>
            <span><?php echo isset($this->_params[1]) ? ($this->_params[1] + 1) : 1; ?></span>
            <?php if ($this->_data['annoncesCount'] >= 6) {
                ?>
                <a class="link-btn"
                   href="/profile/annonces/<?php echo $_SESSION['user']->getId(); ?>/<?php echo isset($this->_params[1]) ? ($this->_params[1] + 1) : 1; ?>">
                    <i class="fas fa-arrow-right"></i></a>
                <?php
            }
            ?>
        </div>
    </div>
</section>
