<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Annonce;
use TDW\Models\Client;
use TDW\Models\Transporteur;

class ProfileController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<title>VTC | Profile</title>';
        echo '<link href="/css/profile.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');

        $this->_data['user'] = $_SESSION['user'];
        $this->_data['transactions'] = $_SESSION['user']->getTransactions();

        if (is_a($_SESSION["user"], \TDW\Models\Client::class)) {
            $this->_data['latestUserAnnonces'] = Annonce::getClientAnnonces($_SESSION['user']->getId(), 4, 0);
        } else if (is_a($_SESSION["user"], \TDW\Models\Transporteur::class)) {
            $this->_data['demandes'] = $_SESSION['user']->getDemandes();
        }

        $this->_view();
    }

    public function annoncesAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!is_a($_SESSION["user"], \TDW\Models\Client::class)) $this->redirect('/notfound');
        if (!isset($this->_params[0])) $this->redirect('/notfound');
        $currentPage = isset($this->_params[1]) ? $this->_params[1] * 6 : 0;
        $annonces = Annonce::getClientAnnonces($_SESSION['user']->getId(), 6, $currentPage);

        $this->_data['annonces'] = $annonces;
        $this->_data['annoncesCount'] = count($annonces);
        $this->_view();
    }

    public function certifierAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!is_a($_SESSION["user"], \TDW\Models\Transporteur::class)) $this->redirect('/notfound');

        if (isset($_POST['submit'])) {
            $title = $this->filterString($_POST['title']);
            $description = $this->filterString($_POST['description']);
            if ($_SESSION['user']->demanderVerification($title, $description)) {
                $_SESSION['successMessage'] = 'Votre demande de vérification a été envoyer,Attendez la vérification des admins';
                $this->redirect('/');
            } else {
                $_SESSION['successMessage'] = 'Il y a un probleme.';
            }
        }
        $this->_view();
    }

    public function summaryAction()
    {
        if (!isset($_SESSION['isAuth']) && !isset($_SESSION["admin"])) $this->redirect('/auth/login');
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect('/notfound');
        $type = $this->_params[0];
        $id = $this->_params[1];
        if ($type == "transporteur") {
            $this->_data["user"] = Transporteur::getTransporteurSummary($id);
            $this->_data["type"] = 0;
        } else {
            $this->_data["user"] = Client::getClientSummary($id);
            $this->_data["type"] = 1;

        }
        $this->_view();
    }

    public function modifierAction()
    {
        if (!isset($_SESSION['isAuth']) && !isset($_SESSION["admin"])) $this->redirect('/auth/login');
        if (!isset($this->_params[0])) $this->redirect('/notfound');

        if (isset($_POST["submit"])) {
            $phone = $this->filterString($_POST["phone"]);
            $commune = $this->filterString($_POST["commune"]);
            $adr = $this->filterString($_POST["adresse"]);
            $res = $_SESSION["user"]->modifyProfile($adr, $commune, $phone);
            if ($res) {
                $_SESSION["successMessage"] = "Vos informations sont modifié";
            } else $_SESSION["errorMessage"] = "Il y a un problème";
        }

        $this->_view();
    }
}