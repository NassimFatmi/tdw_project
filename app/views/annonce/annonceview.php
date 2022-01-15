<?php

namespace TDW\VIEWS\Annonce;

use TDW\Templates\Templates;

class AnnonceView
{
    public function renderCreate()
    {
        $this->createView();
    }

    public function renderDetails()
    {
        $this->detailsView();
    }

    public function renderFind()
    {
        $this->findView();
    }

    private function findView()
    {
        Templates::navbar();
    }

    private function detailsView()
    {
        Templates::navbar();
        Templates::showMessages();
    }

    private function createView()
    {
        Templates::navbar();
    }

    public function annonceDetails($annonce, $client)
    {
        $annonceId = $annonce->getAnnonceId();
        ob_start();
        ?>
        <section class="annonce-details">
            <div class="container">
                <h2 class="secondary-heading">Annonce #<?php echo $annonceId; ?></h2>
                <div class="details">
                    <div class="annonce-image">
                        <img src="<?php echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonceId); ?>">
                    </div>
                    <div class="text">
                        <?php
                        $prix = $annonce->getPrix();
                        if (isset($prix)) {
                            ?>
                            <h3 class="prix">Prix: <?php echo $prix; ?> DA</h3>
                            <?php
                        }
                        ?>
                        <div class="detail">
                            <h5>
                                Client :
                            </h5>
                            <ul>
                                <li>
                                    Nom et Prénom :
                                    <span><?php echo $client['nom'] . ' ' . $client['prenom']; ?></span>
                                </li>
                                <li>
                                    Téléphone :
                                    <span><?php echo $client['phone'] ? $client['phone'] : '/'; ?></span>
                                </li>
                            </ul>
                        </div>
                        <div class="detail">
                            <h5>
                                Description :
                            </h5>
                            <p>
                                <?php echo $annonce->getDescription(); ?>
                            </p>
                        </div>
                        <div class="detail">
                            <?php $pointDepart = $annonce->getPointDepart(); ?>
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
                            <?php $pointArrive = $annonce->getPoinArrive(); ?>
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
                            <?php $poids = $annonce->getPoids(); ?>
                            <h5>
                                L'interval de poids :
                            </h5>
                            <p>
                                <?php echo $poids->getPoidsInterval(); ?>
                            </p>
                        </div>
                        <div class="detail">
                            <?php $type = $annonce->getTypeTransport(); ?>
                            <h5>
                                Type de transport :
                            </h5>
                            <p>
                                <?php echo $type->getTypeName(); ?>
                            </p>
                        </div>
                        <div class="detail">
                            <?php $moyen = $annonce->getMoyTransport(); ?>
                            <h5>
                                Moyen de transport :
                            </h5>
                            <p>
                                <?php echo $moyen->getMoyenName(); ?>
                            </p>
                        </div>
                        <div class="detail status">
                            <h5>
                                Status :
                                <span><?php echo $annonce->isVerified() ? 'Validé' : 'En attente de validation'; ?></span>
                            </h5>
                        </div>
                        <?php
                        if (isset($_SESSION['user']) && is_a($_SESSION['user'], \TDW\Models\Transporteur::class)) {
                            if (!$_SESSION['user']->isPostuled($annonce->getAnnonceId())) {
                                if (!$annonce->isFinished()) {
                                    ?>
                                    <div class="postuler">
                                        <a href="/annonce/postuler/<?php echo $annonce->getAnnonceId(); ?>"
                                           class="link-btn">Postuler</a>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="postuler success-text">
                                    Déja Postuler
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    public function renderForm($wilayasList, $typesList, $poidsIntervalsList, $moyensList)
    {
        ob_start();
        ?>
        <section class="annonce">
            <h2 class="main-heading">Créer une annonce</h2>
            <div class="container">
                <form method="post" enctype="multipart/form-data" onsubmit="validateForm()">
                    <div class="adresse">
                        <h4>Le point de départ :</h4>
                        <input type="text" placeholder="Commune" name="communeDepart">
                        <input type="text" placeholder="Adresse" name="adrDepart">
                        <select name="wilayaDepart">
                            <?php
                            $wilayas = $wilayasList;
                            foreach ($wilayas as $wilaya) {
                                ?>
                                <option value="<?php echo $wilaya->getCode(); ?>"><?php echo $wilaya->getName(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="adresse">
                        <h4>Le point de d'arrivé :</h4>
                        <input type="text" placeholder="Commune" name="communeArrive" required>
                        <input type="text" placeholder="Adresse" name="adrArrive" required>
                        <select name="wilayaArrive" required>
                            <?php
                            $wilayas = $wilayasList;
                            foreach ($wilayas as $wilaya) {
                                ?>
                                <option value="<?php echo $wilaya->getCode(); ?>"><?php echo $wilaya->getName(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <select name="typeDeTransport" required>
                        <?php
                        $types = $typesList;
                        foreach ($types as $type) {
                            ?>
                            <option value="<?php echo $type->getTypeId(); ?>"><?php echo $type->getTypeName(); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div class="choose-poids">
                        Choisissez le poids de votre collier:
                        <?php
                        $poidsIntervals = $poidsIntervalsList;
                        foreach ($poidsIntervals as $poids) {
                            ?>
                            <div class="poids-radio">
                                <input id="<?php echo $poids->getPoidsId(); ?>" type="radio" name="poids"
                                       value="<?php echo $poids->getPoidsId(); ?>"/>
                                <label for="<?php echo $poids->getPoidsId(); ?>">
                                    <?php echo $poids->getPoidsInterval(); ?>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <select name="moyen">
                        <?php
                        $moyens = $moyensList;
                        foreach ($moyens as $moyen) {
                            ?>
                            <option value="<?php echo $moyen->getMoyenId(); ?>"><?php echo $moyen->getMoyenName(); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <textarea maxlength="250" placeholder="Description" name="description"></textarea>
                    <div class="file-form">
                        Image de votre produit :
                        <input type="file" name="file" required accept="image/jpeg,image/jpg,image/png"/>
                        <p class="error-text">L'image de produit est obligatoire</p>
                    </div>
                    <?php Templates::showMessages(); ?>
                    <input class="link-btn" type="submit" name="submit" value="Créer l'annonce">
                </form>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }

    public function renderFindSection($annonce, $transporteursList)
    {
        ob_start();
        ?>
        <section class="find-transporteurs">
            <div class="container">
                <h2 class="secondary-heading">Trouver un transporteur</h2>
                <div class="content">
                    <p>Chercher le transporteur pour votre annonce</p>
                    <div class="card annonce">
                        <img src="<?php echo \TDW\LIB\File::searchFile('annonces', 'annonce', $annonce->getAnnonceId()); ?>">
                        <div class="text">
                            <h3>
                                # <?php echo $annonce->getAnnonceId(); ?>
                            </h3>
                            <p><?php echo $annonce->getDescription(); ?></p>
                        </div>
                    </div>
                    <div class="result">
                        <h4>Les transporteur disponible pour ce trajet</h4>
                        <?php
                        $transporteurs = $transporteursList;
                        if ($transporteurs) {
                            foreach ($transporteurs as $transporteur) {
                                ?>
                                <article class="card transporteur">
                                    <img src="<?php echo \TDW\LIB\File::searchFile('profiles', DS . 'transporteurs' . DS . 'transporteur', $transporteur['transporteurId']); ?>">
                                    <div class="text">
                                        <ul>
                                            <li>Nom : <?php echo $transporteur['nom'];; ?></li>
                                            <li>Prenom : <?php echo $transporteur['prenom'];; ?></li>
                                            <li>Téléphone
                                                : <?php echo $transporteur['phone'] ? $transporteur['phone'] : '/';; ?></li>
                                            <li>Certifier
                                                : <?php echo $transporteur['certifier'] ? 'Oui' : 'Non';; ?></li>
                                        </ul>
                                        <?php
                                        $demande = $_SESSION['user']->isDemander($annonce->getAnnonceId(), $transporteur['transporteurId']);
                                        if ($demande) {
                                            ?>
                                            <span class="success-text">Déja demander</span>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="link-btn"
                                               href="/annonce/demander/<?php echo $annonce->getAnnonceId(); ?>/<?php echo $transporteur['transporteurId']; ?>">Demander</a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </article>
                                <?php
                            }
                        } else {
                            echo 'Il n ya aucun transporteur pour ce trajet...';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        echo ob_get_clean();
    }
}