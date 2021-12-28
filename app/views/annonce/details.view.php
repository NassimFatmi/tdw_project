<?php include_once APP_PATH . DS . 'templates' . DS . 'templatenavbar.php'; ?>
<section class="annonce-details">
    <div class="container">
        <h2 class="secondary-heading">Annonce #<?php echo $this->_data['annonce']->getAnnonceId(); ?></h2>
        <div class="details">
            <div class="annonce-image">
                <img src="<?php echo \TDW\LIB\File::searchFile('annonces', 'annonce', $this->_data['annonce']->getAnnonceId()); ?>">
            </div>
            <div class="text">
                <div class="detail">
                    <h5>
                        Client :
                    </h5>
                    <ul>
                        <li>
                            Nom et Prénom :
                            <span><?php echo $this->_data['annonceClient']['nom'] . ' ' . $this->_data['annonceClient']['prenom']; ?></span>
                        </li>
                        <li>
                            Téléphone :
                            <span><?php echo $this->_data['annonceClient']['phone'] ? $this->_data['annonceClient']['phone'] : '/'; ?></span>
                        </li>
                    </ul>
                </div>
                <div class="detail">
                    <h5>
                        Description :
                    </h5>
                    <p>
                        <?php echo $this->_data['annonce']->getDescription(); ?>
                    </p>
                </div>
                <div class="detail">
                    <?php $pointDepart = $this->_data['annonce']->getPointDepart(); ?>
                    <h5>
                        l'adresse de départ :
                    </h5>
                    <ul>
                        <li>
                            Commune : <span><?php echo $pointDepart->getCommune(); ?></span>
                        </li>
                        <li>
                            Adresse exacte : <span><?php echo $pointDepart->getAdresseExacte(); ?></span>
                        </li>
                        <li>
                            Wilaya : <span><?php echo $pointDepart->getWilaya(); ?></span>
                        </li>
                    </ul>
                </div>
                <div class="detail">
                    <?php $pointArrive = $this->_data['annonce']->getPoinArrive(); ?>
                    <h5>
                        l'adresse d'arrivé :
                    </h5>
                    <ul>
                        <li>
                            Commune : <span><?php echo $pointArrive->getCommune(); ?></span>
                        </li>
                        <li>
                            Adresse exacte : <span><?php echo $pointArrive->getAdresseExacte(); ?></span>
                        </li>
                        <li>
                            Wilaya : <span><?php echo $pointArrive->getWilaya(); ?></span>
                        </li>
                    </ul>
                </div>
                <div class="detail">
                    <?php $poids = $this->_data['annonce']->getPoids(); ?>
                    <h5>
                        L'interval de poids :
                    </h5>
                    <p>
                        <?php echo $poids->getPoidsInterval(); ?>
                    </p>
                </div>
                <div class="detail">
                    <?php $type = $this->_data['annonce']->getTypeTransport(); ?>
                    <h5>
                        Type de transport :
                    </h5>
                    <p>
                        <?php echo $type->getTypeName(); ?>
                    </p>
                </div>
                <div class="detail">
                    <?php $moyen = $this->_data['annonce']->getMoyTransport(); ?>
                    <h5>
                        Moyen de transport :
                    </h5>
                    <p>
                        <?php echo $moyen->getMoyenName(); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>