<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Adresse;
use TDW\Models\Annonce;
use TDW\Models\MoyenTransport;
use TDW\Models\Poids;
use TDW\Models\Transporteur;
use TDW\Models\TypeTransport;
use TDW\Models\Wilaya;

class AnnonceController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<title>VTC | Annonce</title>';
    }

    public function scripts()
    {
        ob_start();
        ?>
        <script>
            function validateForm() {
                const file = document.querySelector('input[type=file]');

                if (file.value === '') {
                    const errorText = document.querySelector('input[type=file]+p.error-text');
                    errorText.classList.add('show');
                    return false;
                }
            }
        </script>
        <?php
        echo ob_get_clean();
    }

    public function createAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        if (!is_a($_SESSION["user"], \TDW\Models\Client::class)) $this->redirect('/notfound');


        $this->_data['moyensTransport'] = MoyenTransport::getAllMoyensTrasport();
        $this->_data['typesTransport'] = TypeTransport::getAllTypesTransport();
        $this->_data['poidsIntervals'] = Poids::getAllPoidsInterval();
        $this->_data['wilayas'] = Wilaya::getWillayas();

        if (isset($_POST['submit'])) {
            $fileSize = $_FILES['file']['size'];
            if ($fileSize < 5000000) {
                $communeDepart = trim($this->filterString($_POST["communeDepart"]));
                $adrDepart = trim($this->filterString($_POST["adrDepart"]));
                $wilayaDepart = trim($this->filterString($_POST["wilayaDepart"]));
                // Le point de départ
                $pointDepart = new Adresse($communeDepart, $adrDepart, $wilayaDepart);

                $communeArrive = trim($this->filterString($_POST["communeArrive"]));
                $adrArrive = trim($this->filterString($_POST["adrArrive"]));
                $wilayaArrive = trim($this->filterString($_POST["wilayaArrive"]));
                // Le point d'arrivé
                $pointArrive = new Adresse($communeArrive, $adrArrive, $wilayaArrive);

                // le type de transport
                $typeTransportId = trim($this->filterInt($_POST['typeDeTransport']));

                $typeTransport = $this->_data['typesTransport'][$typeTransportId - 1];

                // le moyen de transport
                $moyenTransportId = trim($this->filterInt($_POST['moyen']));
                $moyenTransport = $this->_data['moyensTransport'][$moyenTransportId - 1];

                // Le poids
                $poidsId = trim($this->filterInt($_POST['poids']));
                $poids = $this->_data['poidsIntervals'][$poidsId - 1];

                // la description
                $description = trim($this->filterString($_POST['description']));

                $annonce = new Annonce($pointArrive, $pointDepart, $typeTransport, $moyenTransport, $poids, $description);
                // current client id
                $result = $_SESSION['user']->saveClientAnnonce($annonce);
                if ($result) {
                    $_SESSION['successMessage'] = "Votre annonce a été publier";
                    $this->redirect('/');
                } else {
                    $_SESSION['errorMessage'] = 'Il y a un probleme essayer plus tard';
                }
            } else {
                $_SESSION['errorMessage'] = 'Votre fichier est trop large.';
            }
        }
        $this->_view();
    }

    public function detailsAction()
    {
        $annonce = Annonce::getAnnonce($this->_params[0]);
        $this->_data['annonce'] = $annonce;
        $this->_data['annonceClient'] = $annonce->getAnnonceClientName();
        $this->_view();
    }

    public function deleteAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        if (!is_a($_SESSION["user"], \TDW\Models\Client::class)) $this->redirect('/notfound');

        if (!isset($this->_params[0])) $this->redirect('/notfound');

        $annonceId = $this->_params[0];
        if (Annonce::deleteAnnonce($annonceId)) {
            $_SESSION['successMessage'] = "L'annonce a été bien supprimer";
        } else {
            $_SESSION['errorMessage'] = 'Il y a un probleme lors de la suppression';
        }
        $this->redirect('/');
    }

    public function postulerAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        if (!is_a($_SESSION["user"], \TDW\Models\Transporteur::class)) $this->redirect('/notfound');

        if (!isset($this->_params[0]) || !is_numeric($this->_params[0])) $this->redirect('/notfound');
        if ($_SESSION['user']->postuler($this->_params[0])) {
            $_SESSION['successMessage'] = 'Votre demande a été envoyer.';
        } else {
            $_SESSION['errorMessage'] = 'Il y a un probleme essayer plus tard ..';
        }
        $this->redirect('/annonce/details/' . $this->_params[0]);
    }

    public function findAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        if (!is_a($_SESSION["user"], \TDW\Models\Client::class)) $this->redirect('/notfound');

        if (!isset($this->_params[0]) || !is_numeric($this->_params[0])) $this->redirect('/notfound');
        $annonceId = $this->_params[0];

        if (!$_SESSION['user']->isTheOwner($annonceId)) $this->redirect('/notfound');

        $annonce = Annonce::getAnnonce($annonceId);
        $this->_data['annonce'] = $annonce;
        if (!$annonce) $this->redirect('/notfound');

        $transporteurs = Transporteur::getTranspoteursByTrajets($annonce->getPointDepart()->getWilayaCode(), $annonce->getPoinArrive()->getWilayaCode());
        $this->_data['transporteurs'] = $transporteurs;
        $this->_view();
    }

    public function demanderAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        if (!is_a($_SESSION["user"], \TDW\Models\Client::class)) $this->redirect('/notfound');

        if (!isset($this->_params[0]) || !is_numeric($this->_params[0])) $this->redirect('/notfound');

        if (!isset($this->_params[1]) || !is_numeric($this->_params[1])) $this->redirect('/notfound');
        $annonceId = $this->_params[0];

        if ($_SESSION['user']->isTheOwner($annonceId)) {
            $transporteurId = $this->_params[1];
            if ($_SESSION['user']->demanderTransport($annonceId, $transporteurId)) {
                $_SESSION['successMessage'] = 'Votre demande de transport a été envoyer';
            } else {
                $_SESSION['errorMessage'] = 'Il ya un probleme lors de demande essayer plus tard';
            }
            $this->redirect('/');
        } else {
            $this->redirect('/notfound');
        }
    }
}