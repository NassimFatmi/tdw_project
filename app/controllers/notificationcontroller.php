<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Client;
use TDW\Models\Transporteur;

class NotificationController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<title>VTC | Notifications</title>';
        echo '<link href="/css/notification.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) $this->redirect('/auth/login');

        $this->_data['notifications'] = $_SESSION['user']->getNotifications();
        $this->_view();
    }

    public function accepteAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect('/notfound');
        $annonceId = $this->_params[0];
        $demandeId = $this->_params[1];
        if ($_SESSION['user']->accepteDemande($annonceId, $demandeId)) {
            if (is_a($_SESSION['user'], Client::class)) {
                $_SESSION['successMessage'] = 'Vous avez accepter la demande, votre produit sera transpoté dans le prochaine delais.';
                $this->redirect("/notification/note/" . $demandeId);
            } else {
                $_SESSION['successMessage'] = 'Vous avez accepter la demande, Nous allons vous contacter pour le transport via votre numéro.';
            }
        } else {
            $_SESSION['errorMessage'] = 'Il y a un probleme, essayer plus tard.';
        }
        $this->redirect('/notification/default/' . $_SESSION['user']->getId());
    }

    public function refuserAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect('/notfound');
        if ($_SESSION['user']->refuseDemande($this->_params[0], $this->_params[1])) {
            $_SESSION['successMessage'] = 'Vous avez refuser la demande.';
        } else {
            $_SESSION['errorMessage'] = 'Il y a un probleme, essayer plus tard.';
        }
        $this->redirect('/notification/default/' . $_SESSION['user']->getId());
    }

    public function noteAction()
    {
        if (!isset($_SESSION['isAuth'])) $this->redirect('/auth/login');
        if (!isset($this->_params[0])) $this->redirect('/notfound');
        if(isset($_POST['submit'])) {
            $demandeId = $this->_params[0];
            $starsCount = $this->filterInt($_POST['stars']);
            $_SESSION["user"]->rateTransporteur($demandeId,$starsCount);
            $this->redirect("/");
        }
        $this->_view();
    }
}