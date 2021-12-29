<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Adresse;
use TDW\Models\Annonce;
use TDW\Models\MoyenTransport;
use TDW\Models\Poids;
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

    public function createAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) {
            $this->redirect('/auth/login');
            exit;
        }
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
}