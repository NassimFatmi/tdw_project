<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Annonce;

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

    public function certifierAction () {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!is_a($_SESSION["user"], \TDW\Models\Transporteur::class)) $this->redirect('/notfound');

        if(isset($_POST['submit']))  {
            $title = $this->filterString($_POST['title']);
            $description = $this->filterString($_POST['description']);
            if($_SESSION['user']->demanderVerification($title,$description)) {
                $_SESSION['successMessage'] = 'Votre demande de vérification a été envoyer,Attendez la vérification des admins';
                $this->redirect('/');
            } else {
                $_SESSION['successMessage'] = 'Il y a un probleme.';
            }
        }
        $this->_view();
    }
}