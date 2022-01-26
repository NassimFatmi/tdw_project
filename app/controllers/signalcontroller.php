<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;

class SignalController extends AbstractController
{
    use Helper;
    use InputFilter;

    public function init()
    {
        echo '<title>VTC | Signaler</title>';
        echo '<link href="/css/signal.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        if (!$this->isAuthenticated()) $this->redirect("/auth/login");
        $this->_data["transporteurId"] = $this->_params[0];
        if (isset($_POST["submit"])) {
            $transporteurId = $this->_params[0];
            $objet = $this->filterString($_POST["objet"]);
            $message = $this->filterString($_POST["message"]);
            if ($_SESSION["user"]->signaler($transporteurId, $objet, $message)) {
                $_SESSION["successMessage"] = "Vous avez signalé le transporteur";
                $this->redirect("/");
            } else {
                $_SESSION["errorMessage"] = "Il y a un probleme lors de le signale";
            }
        }
        $this->_view();
    }
}